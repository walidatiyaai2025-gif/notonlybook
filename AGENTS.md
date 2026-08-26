# Repository Constitution — NotOnlyBook Product Family

This repository is a **PRODUCT FAMILY**, not a single undifferentiated client build.

## Authoritative worker entrypoint

Every implementation worker MUST start from a Project Control Center routing packet before modifying code.

Authoritative routing authority:

`walidatiyaai2025-gif/project-control-center`

The routing packet must identify at minimum:
- `PROJECT_ID`
- `REPOSITORY`
- `TARGET_SCOPE`
- `TARGET_VARIANT` when scope is variant-specific
- `CONSTITUTION_PATH`
- `FAMILY_MANIFEST_PATH`
- the permitted change boundary

If a worker does not have an authoritative routing packet, it may inspect the repository read-only, but MUST NOT make implementation changes. It must return `ROUTING_REQUIRED` instead of guessing the client, variant, branch, or change scope.

## Owner-declared variants

This family currently contains two active variants:

1. `NOTONLYBOOK` — primary product variant.
2. `ARABIASWONDERS` — client variant derived from the same product family.

Aliases such as `arabiaswonder`, `arabiaswonders`, and `Arabias Wonders` all resolve to `ARABIASWONDERS`.

The machine-readable authority is `.pcc/project-family.json`.

## Change-boundary law

Before editing any file, the worker must classify each intended change as one of:
- `SHARED_CORE`
- `NOTONLYBOOK_ONLY`
- `ARABIASWONDERS_ONLY`
- `UNKNOWN`

`UNKNOWN` is a write blocker. The worker must investigate and establish the boundary before modifying code.

A client-specific request must not leak branding, configuration, content, deployment settings, or behavior into another variant.

A shared-core change must be treated as potentially affecting every active variant and requires cross-variant validation before completion.

## Physical layout is evidence-driven

Do not infer variant identity from branch names. Long-lived client identity is defined by the family manifest and PCC routing, not by a branch naming convention.

The current physical implementation locations of the variants must be discovered from live repository evidence and then recorded in `.pcc/project-family.json`. Until a location is verified, it remains `UNRESOLVED`; workers must not invent directories, branches, domains, or deployment targets.

## Branch and merge rules

- A task branch is temporary implementation state, not a client identity.
- Do not create permanent divergent client branches as a substitute for an explicit variant architecture unless the owner authorizes that model.
- Shared fixes should be implemented once at the correct shared boundary wherever the repository architecture supports that safely.
- Variant-only fixes must remain isolated to the routed variant.
- Never merge a variant-specific customization into shared code merely to make a test pass.

## Build and release identity

Any build, package, deployment evidence, or release artifact for this product family must identify the target variant. A generic artifact with an ambiguous target is not authoritative release evidence.

## Required read order for workers

1. This `AGENTS.md`.
2. `.pcc/project-family.json`.
3. The Project Control Center routing packet supplied for the task.
4. Task-specific repository evidence and applicable project documentation.

If these sources conflict, stop implementation and return the conflict to the Project Control Center for routing reconciliation.
