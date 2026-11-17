# ITMOSOFT Laravel Tenders

Tender publishing and bid submission workflows for Laravel applications, with deadlines, polymorphic issuers and bidders, evaluation scores, and award tracking.

## Features

- Polymorphic tender issuer
- Tender reference, title, scope and submission deadline
- Draft, published, closed, awarded and cancelled lifecycle
- Polymorphic bidder submissions
- Bid amount, currency, proposal and evaluation score
- Award one submission and record award decision

## Requirements

- PHP 8.3+
- Laravel 12 or 13

## Installation

```bash
composer require itmosoft/laravel-tenders
php artisan vendor:publish --tag=tenders-config
php artisan migrate
```

## Usage

Use the package's Eloquent model under `ITMOSOFT\\Tenders\\Models\\Tender`. Create records with the required polymorphic relation fields and use the model lifecycle methods documented below.

### Lifecycle methods

- `publish()` publishes a draft tender if its deadline has not passed.
- `close()` closes a published tender.
- `award($submission)` awards a submitted bid belonging to this tender.

## Important boundaries

This package provides persistence models and lifecycle primitives. It does not provide authentication, authorization, approval routing, notifications, file uploads, electronic signatures, payment processing, or tenant isolation. Enforce permissions and business-specific validation in the host application. File paths and document metadata are references only; implement secure upload, storage, access control, and malware scanning in the application.

## Testing

```bash
composer install
composer test
```

## License

MIT.
