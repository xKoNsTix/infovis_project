# Energy Visualization Dashboard

This project provides a web-based dashboard for visualizing energy consumption data, pulling information directly from sensors configured in Home Assistant. It's hosted on [infovis.tokowa.at](https://infovis.tokowa.at) and consists of source (`src`) and distribution (`dist`) directories to separate the development environment from the production-ready code.

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

- PHP 7.4 or higher
- Access to Home Assistant with sensors configured for energy consumption -> config file not provided
- Composer for managing PHP dependencies (if any)

### Installation

1. Clone the repository to your local machine or server.

```bash
git clone https://github.com/xKoNsTix/infovis_project
cd dist
php -S localhost:8001
```

