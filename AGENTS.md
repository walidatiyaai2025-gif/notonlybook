# Repository Constitution — NotOnlyBook Product Family

This repository is a **PRODUCT_FAMILY** governed through the Project Control Center (PCC).

## Authoritative entrypoint

Every implementation Worker, Manager, Lead, QA, Integration, or Release role MUST begin with the PCC routing decision and then read this constitution plus `.pcc/project-family.json`.

Routing authority:
`walidatiyaai2025-gif/project-control-center`

No implementation write is allowed without `ROUTING_STATUS=ROUTED` for the requested boundary. If routing is absent, stale, blocked, or contradicts live repository evidence, return `ROUTING_REQUIRED` or `ROUTING_CONFLICT` and do not guess.

## Product-family identity

Known active variants:

1. `NOTONLYBOOK` — primary variant.
2. `ARABIASWONDERS` — owner-declared client variant derived from this product family.

Aliases `arabiaswonder`, `arabiaswonders`, and `Arabias Wonders` resolve to `ARABIASWONDERS`.

The machine-readable authority is `.pcc/project-family.json`.

## Current verified physical boundaries

Evidence at source SHA `409bac608ecb4727d56efb7649be64934800e5cd` establishes the current repository-root WordPress theme as the `NOTONLYBOOK` implementation: its theme metadata identifies `NotOnlyBook Modern`, `https://notonlybook.com/`, and author `NotOnlyBook`.

Therefore:
- `NOTONLYBOOK`: implementation location `.`; routing state `READY`.
- `ARABIASWONDERS`: implementation location is not proven in current live repository evidence; routing state `BLOCKED_UNRESOLVED`.
- shared-core boundary: not proven independently; `CORE_ROUTING_STATE=BLOCKED_UNRESOLVED`.

A blocked/unresolved variant is still a real registered business/product identity. It MUST NOT be materialized by inventing a folder, permanent client branch, external repository, domain, deployment target, or copied source merely to make routing pass.

## Change-boundary law

Before editing code, the Worker must use the PCC packet to establish exactly one allowed scope:
- `CORE`
- `VARIANT:NOTONLYBOOK`
- `VARIANT:ARABIASWONDERS`

Current consequences:
- `VARIANT:NOTONLYBOOK` may proceed only when PCC routes it to implementation location `.`.
- `VARIANT:ARABIASWONDERS` is write-blocked until PCC and this manifest are amended with verified implementation evidence.
- `CORE` is write-blocked until a shared-core boundary is verified.

Client-specific branding, configuration, content, deployment settings, or behavior must never leak into another variant.

## No branch-as-client identity

A Git branch is temporary implementation state, not long-lived client identity. Do not infer a variant from a branch name and do not create permanent client branches as a substitute for explicit family governance.

## Durable decision law

Any durable decision that changes family identity, variant aliases, implementation locations, shared-core boundaries, or routing state must be persisted in BOTH:
1. this repository's `.pcc/project-family.json` / constitution as applicable; and
2. PCC committed routing/policy state.

Conversation, Worker memory, and temporary prompts are not canonical governance. A replacement Manager/Lead must be able to reconstruct the model from committed GitHub state alone.

## Build / QA / release identity

Every build, QA result, package, deployment record, and release artifact must identify the target variant and exact source SHA. Generic family artifacts with ambiguous target identity are non-authoritative.

## Required read order

1. This `AGENTS.md`.
2. `.pcc/project-family.json`.
3. `.pcc/managed-repository-control.json`.
4. The current PCC routing packet.
5. Task-specific repository evidence.

If they conflict, stop writes and escalate the conflict to PCC for constitutional/routing reconciliation.
