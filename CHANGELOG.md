# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.1.0] - 2026-10-12

### Added

- Added PHPUnit coverage for rendering, layout configuration, asset URLs, view paths, and DTOs.
- Added PHPStan analysis at the maximum level and Composer scripts for linting, tests, and static analysis.
- Added package installation, configuration, usage, and development documentation.
- Added an MIT license.

### Changed

- Added PHP 8.5 compatibility while retaining PHP 8.3 and 8.4 support.
- Upgraded `websk/php-config` from 2.0 to 2.2.
- Upgraded `websk/php-utils` from 2.1 to 3.0.
- Upgraded `websk/php-slim` to 2.4.
- Changed the Composer autoload mapping to PSR-4 namespace `WebSK\\`.
- Added native property, parameter, and return types throughout the public API.
- Added strict validation for configuration values and the current Slim request.
- Excluded development caches, IDE metadata, and installed dependencies from release archives.

### Fixed

- Restored the output-buffer level when a rendered template throws an exception.
- Rejected invalid module fallback paths instead of building a path from an invalid offset.
- Made template rendering and view-path failures explicit instead of returning invalid values.

## [2.3.0] - 2025-03-26

### Changed

- Upgraded `websk/php-slim` from 2.2 to 2.3.

## [2.2.2] - 2025-03-25

### Changed

- Upgraded `websk/php-utils` from 2.0 to 2.1.

## [2.2.1] - 2025-03-15

### Added

- Added `slim/php-view` 3.4 as an explicit dependency.

## [2.2.0] - 2024-09-01

### Changed

- Upgraded `websk/php-slim` from 2.1 to 2.2.

## [2.1.0] - 2024-09-01

### Changed

- Upgraded `websk/php-slim` from 2.0 to 2.1.

## [2.0.0] - 2024-08-08

### Changed

- Raised the minimum PHP version to 8.3.
- Upgraded `websk/php-utils`, `websk/php-config`, and `websk/php-slim` to their 2.x release lines.
- Added native types to view helpers and DTOs.

## [1.1.0] - 2022-02-13

### Changed

- Updated Composer dependencies.
- Added module namespace directory support.

[Unreleased]: https://github.com/websk/php-view/compare/3.1.0...HEAD
[3.1.0]: https://github.com/websk/php-view/compare/2.3.0...3.1.0
[2.3.0]: https://github.com/websk/php-view/releases/tag/2.3.0
[2.2.2]: https://github.com/websk/php-view/releases/tag/2.2.2
[2.2.1]: https://github.com/websk/php-view/releases/tag/2.2.1
[2.2.0]: https://github.com/websk/php-view/releases/tag/2.2.0
[2.1.0]: https://github.com/websk/php-view/releases/tag/2.1.0
[2.0.0]: https://github.com/websk/php-view/releases/tag/2.0.0
[1.1.0]: https://github.com/websk/php-view/releases/tag/1.1.0
