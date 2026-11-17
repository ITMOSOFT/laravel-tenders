# Release instructions

- Repository: `ITMOSOFT/laravel-tenders`
- Composer package: `itmosoft/laravel-tenders`
- Initial tag: `v1.0.0`

## Validate locally

```bash
composer validate --strict
composer install
composer test
```

## User-run Git commands

Run these yourself after local tests pass and GitHub Actions succeeds:

```bash
git add .
git commit -m "chore: prepare tenders v1.0.0"
git push origin main
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0
```

## GitHub Release

Title: `v1.0.0 — Initial Release`

Description:

```markdown
## Highlights

- Polymorphic tender issuer.
- Tender reference, title, scope and submission deadline.
- Draft, published, closed, awarded and cancelled lifecycle.
- Polymorphic bidder submissions.
- Bid amount, currency, proposal and evaluation score.
- Award one submission and record award decision.

## Requirements

- PHP 8.3+
- Laravel 12 or 13

## Installation

composer require itmosoft/laravel-tenders
php artisan migrate

```

## Packagist

Submit the public repository at https://packagist.org/packages/submit and verify that Packagist detects `v1.0.0`.
