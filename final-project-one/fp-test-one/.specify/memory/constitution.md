<!--
Sync Impact Report
- Version change: unknown → 1.0.0
- Modified principles: [PRINCIPLE_1_NAME] → Code Quality Discipline; [PRINCIPLE_2_NAME] → Testing Standards; [PRINCIPLE_3_NAME] → UX Consistency; [PRINCIPLE_4_NAME] → Performance & Reliability; [PRINCIPLE_5_NAME] → intentionally omitted (not needed)
- Added sections: "Non‑Functional Standards & Constraints", "Development Workflow & Quality Gates"
- Removed sections: None
- Templates requiring updates:
	- .specify/templates/plan-template.md ✅ updated
	- .specify/templates/spec-template.md ✅ updated
	- .specify/templates/tasks-template.md ✅ updated
- Follow-up TODOs:
	- TODO(CI_WORKFLOW): Add CI workflow to run Pint, static analysis, tests with coverage thresholds, and publish reports.
	- TODO(STATIC_ANALYSIS): Introduce PHPStan or Psalm with baseline and configure to run in CI and locally.
-->

# FP Test One Constitution

## Core Principles

### I. Code Quality Discipline (NON-NEGOTIABLE)

All production code MUST meet the following quality bars:

-   Style & formatting: PSR-12 compliant and auto-formatted with Laravel Pint; CI MUST fail on any violations.
-   Correctness by construction: Prefer pure functions, immutability where feasible, and explicit error handling.
-   Types & contracts: Public methods and constructors MUST declare parameter and return types; avoid mixed/array typing without dedicated DTOs.
-   Complexity & size: Functions ≤ 50 lines and cyclomatic complexity ≤ 10; larger units MUST be refactored before merge unless justified in plan.md "Complexity Tracking".
-   No dead code: Remove unused code/vars; no commented-out blocks; no lingering TODOs without an associated task ID.

Rationale: High-quality code reduces defects, accelerates reviews, and enables safe change.

### II. Testing Standards (MANDATORY, Test-First Preferred)

Every change MUST be covered by automated tests and adhere to:

-   Scope: Unit tests for services/helpers; Feature/HTTP tests for endpoints and user flows; Integration tests for DB/queue boundaries.
-   Determinism: Tests MUST be hermetic—no external network calls; use fakes/mocks, factories, and transactions.
-   Coverage: ≥ 80% line coverage repo-wide, ≥ 90% on critical domains; CI MUST publish coverage and block PRs below thresholds.
-   Workflow: Red→Green→Refactor is encouraged; tests for a story SHOULD be written before implementation where practical.

Rationale: Tests document behavior, prevent regressions, and enable refactoring.

### III. UX Consistency (Accessibility Included)

User experience MUST be consistent and accessible across the app:

-   Components: Reuse Blade components for UI primitives (buttons, forms, alerts) under `resources/views/components/`; no one-off styles for shared patterns.
-   Accessibility: Conform to WCAG 2.1 AA—semantic HTML, labeled controls, focus order, keyboard navigation, color contrast.
-   Validation & errors: Consistent inline error presentation and messaging via translations (`trans()` / `__()`); no raw strings in templates.
-   Responsiveness: Mobile-first layouts; shared spacing/typography scales; avoid layout shift; test at common breakpoints.

Rationale: Consistency improves usability, reduces cognitive load, and broadens accessibility.

### IV. Performance & Reliability (Budget-Driven)

The system MUST meet defined performance budgets and avoid pathological patterns:

-   Server latency: p95 TTFB ≤ 200ms for simple GET pages (warm cache), ≤ 300ms for authenticated actions.
-   Database discipline: No N+1 queries (use eager loading/withCount); ≤ 20 queries per request by default; add indexes for slow lookups.
-   Asset budget: Critical path pages ≤ 200KB gzipped for app JS/CSS; defer non-critical assets; images optimized/responsive.
-   Work off main path: Use queues for slow work; set idempotency and timeouts; retries configured for transient failures.

Rationale: Budgets guard user experience and infrastructure cost while making performance a first-order design constraint.

## Non-Functional Standards & Constraints

-   Branching & naming: Feature branches follow `[###-feature-name]`; specs and plans live under `specs/` per templates.
-   Linting & static analysis: Laravel Pint MUST run clean; static analysis (e.g., PHPStan/Psalm) MUST report 0 errors for touched code.
-   Migrations: Forward-only migrations; provide down paths where feasible; never modify applied migrations—create follow-ups.
-   Secrets & config: No secrets in repo; use `.env` and Laravel config; validate required env vars in boot.
-   Logging: Use structured logs for errors and important domain events; avoid logging PII.

## Development Workflow & Quality Gates

PRs MUST pass all gates before merge:

-   Build gates: Composer autoload dump, Pint, static analysis, and full test suite with coverage thresholds.
-   UX gates: Screens changed include a short before/after screenshot (or storybook-like reference) and pass accessibility checks.
-   Performance gates: New/changed endpoints document expected budgets in spec/plan and show a local benchmark or reasoning.
-   Review gates: At least one maintainer approval; any exceptions documented in plan.md "Complexity Tracking" with rationale and expiry.

## Governance

-   Authority: This constitution supersedes team conventions when in conflict.
-   Amendments: Proposed via PR with a summary of changes, migration/impact notes, and updated version/date. Approval by maintainers required.
-   Versioning policy: Semantic—MAJOR for breaking governance changes, MINOR for new principles/sections, PATCH for clarifications.
-   Compliance reviews: Quarterly audits of open PRs and key modules against principles and gates; findings tracked as tasks.

**Version**: 1.0.0 | **Ratified**: 2025-10-13 | **Last Amended**: 2025-10-13
