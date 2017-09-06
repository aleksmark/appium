# Description

Run appium server version 1.6.5-beta. The setup includes android sdk (version 26.0.2) with platform and build tools libraries and one test AVD.

## Prerequisites

Docker

https://docs.docker.com/engine/installation/

Docker-compose

https://docs.docker.com/v1.11/compose/install/

##### Note: you should be able to run docker without sudo

## Installation

Clone the project

```
$ git clone git@github.com:aleksmark/appium.git
$ cd appium
```

Build the docker environment

```
$ docker-compose up -d
```

Start android virtual device (AVD)

```
$ docker exec -it appium bash -c "emulator @testavd -no-window" &
```

Make sure the AVD is started

```
$ docker exec -it appium bash -c "adb devices"
```

Install composer dependencies


```
$ cd php-client && composer install
```

Run the tests

```
$ cd php-client && vendor/bin/phpunit Test
```





$ docker run -d --privileged -p 4723:4723 --name appium alphafounders/appium:1.6.5
