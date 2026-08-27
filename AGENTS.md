# Repository Constitution — NotOnlyBook Product Family

This repository is a **PRODUCT_FAMILY** governed through the Project Control Center (PCC).

## Authoritative entrypoint

Every implementation Worker, Manager, Lead, QA, Integration, or Release role MUST begin with the PCC routing decision and then read this constitution plus `.pcc/project-family.json`.

Routing authority:
`walidatiyaai2025-gif/project-control-center`

No implementation write is allowed without `ROUTING_STATUS=ROUTED` for the requested boundary. If routing is absent, stale, blocked, or contradicts live repository evidence, return `ROUTING_REQUIRED` or `ROUTING_CONFLICT` and do not guess.

## Product-family identity

Known active variants:

1. `NOTONLYBOOK` — primary client/product variant.
2. `ARABIASWONDERS` — distinct client variant derived from the same product family.

Aliases `arabiaswonder`, `arabiaswonders`, and `Arabias Wonders` resolve to `ARABIASWONDERS`.

The machine-readable authority is `.pcc/project-family.json`.

## Current verified physical boundaries

The current WordPress theme source is implemented at repository root `.`.

Owner authority establishes that `ARABIASWONDERS` currently uses the same repository-root source code as `NOTONLYBOOK`, while remaining a **distinct client identity** for all future routing, tasks, QA, releases, deployment evidence, branding/configuration/content, and monitoring.

Therefore:
- `NOTONLYBOOK`: implementation location `.`; routing state `READY`; distinct client identity.
- `ARABIASWONDERS`: implementation location `.`; routing state `READY`; distinct client identity sharing the current source root with `NOTONLYBOOK`.
- shared-core boundary remains independently unresolved; `CORE_ROUTING_STATE=BLOCKED_UNRESOLVED` until a reusable shared-core boundary is explicitly proven.

Sharing the same source location does NOT make the clients interchangeable. A request naming ArabiasWonders must route to `VARIANT:ARABIASWONDERS`, not to `VARIANT:NOTONLYBOOK`.

## Change-boundary law

Before editing code, the Worker must use the PCC packet to establish exactly one allowed scope:
- `CORE`
- `VARIANT:NOTONLYBOOK`
- `VARIANT:ARABIASWONDERS`

Current consequences:
- `VARIANT:NOTONLYBOOK` may proceed only when PCC routes it explicitly to NotOnlyBook.
- `VARIANT:ARABIASWONDERS` may proceed only when PCC routes it explicitly to ArabiasWonders.
- Client-specific branding, configuration, content, deployment settings, monitoring, release identity, or behavior must never leak into the sibling client merely because both currently share repository root `.`.
- If a requested variant-specific change cannot be isolated safely in the shared source tree, stop and return `VARIANT_ISOLATION_REQUIRED` instead of silently changing both clients.
- `CORE` remains write-blocked until a shared-core boundary is verified.

## No branch-as-client identity

A Git branch is temporary implementation state, not long-lived client identity. Do not infer a variant from a branch name and do not create permanent client branches as a substitute for explicit family governance.

## Durable decision law

Any durable decision that changes family identity, variant aliases, implementation locations, shared-core boundaries, client-isolation rules, or routing state must be persisted in BOTH:
1. this repository's `.pcc/project-family.json` / constitution as applicable; and
2. PCC committed routing/policy state.

Conversation, Worker memory, and temporary prompts are not canonical governance. A replacement Manager/Lead must be able to reconstruct the model from committed GitHub state alone.

## Build / QA / release identity

Every build, QA result, package, deployment record, monitor record, and release artifact must identify the target variant and exact source SHA. Generic family artifacts with ambiguous target identity are non-authoritative.

Even when two variants are built from the same source SHA, their client identity remains separate and must be stated explicitly as `NOTONLYBOOK` or `ARABIASWONDERS`.

## Required read order

1. This `AGENTS.md`.
2. `.pcc/project-family.json`.
3. `.pcc/managed-repository-control.json`.
4. The current PCC routing packet.
5. Task-specific repository evidence.

If they conflict, stop writes and escalate the conflict to PCC for constitutional/routing reconciliation.
