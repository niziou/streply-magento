# Streply Magento Module
Streply SDK for Magento framework

### Install
Install the `streply/streply-php`:

```bash
composer require streply/streply-php
```

Install the `streply/streply-magento` package:

```bash
composer require streply/streply-symfony
```

Enable module and run migration
```bash
bin/magento module:enable Streply_StreplyMagento
```
```bash
bin/magento setup:upgrade
```

### Config
Add default API key configuration and set module output in Config > Streply > General

### Add flush to magento entry files:
```bash
Magento_dir/pub/index.php
```
and 
```bash
Magento_dir/bin/magento.php
```
add line:
```bash
\Streply\Flush();
```
at the bottom of each file.
