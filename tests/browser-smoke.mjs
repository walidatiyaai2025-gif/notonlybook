import { chromium } from 'playwright';

const base = process.env.NOB_BASE_URL || 'http://127.0.0.1:8888';
const viewports = [
  { name: 'desktop-1440', width: 1440, height: 1000 },
  { name: 'tablet-768', width: 768, height: 1000 },
  { name: 'mobile-390', width: 390, height: 844 },
  { name: 'mobile-360', width: 360, height: 800 },
  { name: 'mobile-320', width: 320, height: 700 },
];

const routes = [
  ['home', '/'],
  ['archive', '/?cat=1'],
  ['single', '/?p=1'],
  ['page', '/?page_id=2'],
  ['search', '/?s=closure'],
  ['404', '/notonlybook-closure-missing-route/'],
];

const browser = await chromium.launch();
let failures = [];
let checks = 0;

function fail(message) {
  failures.push(message);
}

for (const viewport of viewports) {
  const context = await browser.newContext({ viewport });
  const page = await context.newPage();

  page.on('pageerror', error => fail(`${viewport.name}: pageerror: ${error.message}`));
  page.on('console', message => {
    if (message.type() === 'error') {
      fail(`${viewport.name}: console error: ${message.text()}`);
    }
  });

  for (const [name, route] of routes) {
    const response = await page.goto(new URL(route, base).toString(), { waitUntil: 'networkidle' });
    checks++;
    if (!response || response.status() >= 500) {
      fail(`${viewport.name}/${name}: HTTP ${response?.status() ?? 'no response'}`);
      continue;
    }

    checks++;
    if ((await page.locator('main#main').count()) !== 1) {
      fail(`${viewport.name}/${name}: expected one main#main landmark`);
    }

    const overflow = await page.evaluate(() => ({
      scroll: document.documentElement.scrollWidth,
      client: document.documentElement.clientWidth,
    }));
    checks++;
    if (overflow.scroll > overflow.client + 1) {
      fail(`${viewport.name}/${name}: horizontal overflow ${overflow.scroll} > ${overflow.client}`);
    }

    const imagesMissingAlt = await page.locator('img:not([alt])').count();
    checks++;
    if (imagesMissingAlt > 0) {
      fail(`${viewport.name}/${name}: ${imagesMissingAlt} image(s) missing alt attribute`);
    }

    await page.evaluate(() => document.documentElement.setAttribute('dir', 'rtl'));
    const rtlOverflow = await page.evaluate(() => ({
      scroll: document.documentElement.scrollWidth,
      client: document.documentElement.clientWidth,
    }));
    checks++;
    if (rtlOverflow.scroll > rtlOverflow.client + 1) {
      fail(`${viewport.name}/${name}: RTL horizontal overflow ${rtlOverflow.scroll} > ${rtlOverflow.client}`);
    }
    await page.evaluate(() => document.documentElement.removeAttribute('dir'));
  }

  await page.goto(base, { waitUntil: 'networkidle' });
  const searchToggle = page.locator('.nob-search-toggle');
  if (await searchToggle.isVisible()) {
    await searchToggle.focus();
    checks++;
    if (!(await searchToggle.evaluate(el => el === document.activeElement))) {
      fail(`${viewport.name}: search toggle cannot receive keyboard focus`);
    }
    await searchToggle.press('Enter');
    checks++;
    if ((await searchToggle.getAttribute('aria-expanded')) !== 'true') {
      fail(`${viewport.name}: search toggle did not open with keyboard`);
    }
    checks++;
    if (!(await page.locator('#nob-header-search input[type="search"]').isFocused())) {
      fail(`${viewport.name}: opened search did not move focus to search field`);
    }
    await page.keyboard.press('Escape');
    checks++;
    if ((await searchToggle.getAttribute('aria-expanded')) !== 'false') {
      fail(`${viewport.name}: Escape did not close search disclosure`);
    }
  }

  const menuToggle = page.locator('.nob-menu-toggle');
  if (await menuToggle.isVisible()) {
    await menuToggle.focus();
    await menuToggle.press('Enter');
    checks++;
    if ((await menuToggle.getAttribute('aria-expanded')) !== 'true') {
      fail(`${viewport.name}: mobile menu did not open with keyboard`);
    }
    checks++;
    if (await page.locator('#nob-mobile-panel').getAttribute('hidden') !== null) {
      fail(`${viewport.name}: mobile panel remained hidden after open`);
    }
    await page.keyboard.press('Escape');
    checks++;
    if ((await menuToggle.getAttribute('aria-expanded')) !== 'false') {
      fail(`${viewport.name}: Escape did not close mobile menu`);
    }
  }

  await context.close();
}

await browser.close();

console.log(`NOTONLYBOOK browser smoke: ${checks} checks, ${failures.length} failures`);
if (failures.length) {
  for (const failure of failures) console.error(`FAIL: ${failure}`);
  process.exit(1);
}
