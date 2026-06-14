<div>
  <img src="./docs/icon.png" alt="WebRuntime" height="64" style="vertical-align: middle;">
  <span style="font-size: 32px; font-weight: 700; vertical-align: middle; margin-left: 12px;">
    WebRuntime
  </span>
</div>

![version](https://img.shields.io/badge/version-0.2.0-blue)
---
A lightweight PHP framework for websites, including sessions, actions, file-based routing, and more.

## Requirements & Setup
- PHP 8.4+
- Sessions enabled

### Setup
1. Clone the repository
2. Add to your PHP file: `require_once "your_path/WebRuntime.php"`
3. See the Usage Example below
4. Run phps builtin server using: `php -S 127.0.0.1:8080`

## Usage Example
```php
use WebRuntime\WebRuntime;

$webruntime = new WebRuntime(
    base_url: "127.0.0.1:8080", // or any url domain.ee
    views_dir: "./views", // Your directory containing html and php files
    debug_mode: true
);

$webruntime->execute();
```

### Core Routing Rules
- `index.html`/`index.php` -> `/`
- `about.html` -> `/about`
- `user/profile.php` -> `/user/profile`
- `views/home.prefix` -> `home.example.ee`
  - `.prefix` enables subdomain routing
