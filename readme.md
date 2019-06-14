# 畅游通sdk for laravel
[![License](http://www.wtfpl.net/wp-content/uploads/2012/12/wtfpl-badge-1.png)](LICENSE)
## 安装
```bash
composer require dezsidog/laracyt
```

## 使用
```php
$sdk = app(Dezsidog\CytSdk\Sdk::class);
```

### 钩子
扩展自带通知钩子，默认url为: http://xxx.com/api/cyt-hook，可以在配置文件中修改。