# Monolog workshop

### Run this in your terminal first
`export uid=$(id -u)`

`export gid=$(id -g)`

### Then you can run
`make install`

### Help
If you've the following error : `adduser: invalid number '-G'` it means you don't have the env var uid and/or gid, export them in your terminal or add them to your profile (to make them persistent)




# Why is it important to log correctly ?

- monitoring
- debug
- alerting
- stats

# Require monolog

`composer require symfony/monolog-bundle`

# Configure monolog

- setup the config for every environment needed
- read https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md
- check with the SRS/DevOps/SysAdmin/Whatever the name which are their request ! Don't forget that you work in team with them
- test the prod config in dev to be sure you made no mistake
- use the channels if you really need them 

# How to log

```php
# Use debug to log technical stuff
$this->logger->debug('Parsing incoming request', ['request' => $request]);
# Use info to log what's going on
$this->logger->info('Processing Product creation', ['data' => $data]);
# Use warning to log strange behavior but non-blocking
$this->logger->warning('Cannot delete non-existent Product', ['product_id'=> $productId]);
# Use error to log detail about blocking exception
$this->logger->error('Cannot save Product to database', ['exception' => $e, 'product' => $product]);
# Use critical/emergency to log really critical stuff
$this->logger->emergency('Cannot access database', ['exception' => $e, 'host' => $host, 'database' => $database, 'user' => $user]);
```

You can also use notice/alert in specific context

# How to inject logger

```php
<?php

declare(strict_types=1);

namespace App;

class Something implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct() 
    {
        $this->setLogger(new \NullLogger());
    }
}
```

# When to log ?

ALWAYS !!!!!

Really, log everything even if you think it's not important (use the loglevel to indicate if the log is important or not).

