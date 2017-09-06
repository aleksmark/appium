FROM ubuntu:16.04

LABEL maintainer "Aleksandar Markicevic <aleksandarm@rabbit.co.th>"

WORKDIR /root

ENV DEBIAN_FRONTEND=noninteractive \
    DEBCONF_NONINTERACTIVE_SEEN=true

RUN echo "deb http://archive.ubuntu.com/ubuntu xenial main universe\n" > /etc/apt/sources.list && \
    echo "deb http://archive.ubuntu.com/ubuntu xenial-updates main universe\n" >> /etc/apt/sources.list && \
    echo "deb http://security.ubuntu.com/ubuntu xenial-security main universe\n" >> /etc/apt/sources.list && \
    apt-get update -qqy && \
    apt-get -qqy --no-install-recommends install \
    ca-certificates \
    openjdk-8-jre-headless && \
    sed -i 's/securerandom.source=file:\/dev\/urandom/securerandom.source=file:\/dev\/.\/urandom/g' \
       /usr/lib/jvm/java-8-openjdk-amd64/jre/lib/security/java.security && \
    sed -i 's/securerandom.source=file:\/dev\/random/securerandom.source=file:\/dev\/.\/urandom/g' \
       /usr/lib/jvm/java-8-openjdk-amd64/jre/lib/security/java.security && \
    apt-get -qyy autoremove && \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/*

RUN apt-get update -qqy && \
    apt-get -qqy --no-install-recommends install --fix-missing \
    tzdata \
    curl \
    xvfb \
    x11vnc \
    wget \
    libqt5webkit5 \
    unzip \
    libpulse0 && \
  { \
        echo '#!/bin/sh'; \
        echo 'set -e'; \
        echo; \
        echo 'dirname "$(dirname "$(readlink -f "$(which javac || which java)")")"'; \
    } > /usr/local/bin/docker-java-home && \
    chmod +x /usr/local/bin/docker-java-home && \
  apt-get -qyy autoremove && \
  rm -rf /var/lib/apt/lists/* /var/cache/apt/*

ENV JAVA_HOME="/usr/lib/jvm/java-8-openjdk-amd64/jre" \
    PATH=$PATH:$JAVA_HOME/bin

ENV ANDROID_BUILD_TOOLS_VERSION=25.0.3 \
    ANDROID_HOME=/root

ENV PATH=$PATH:$ANDROID_HOME/emulator:$ANDROID_HOME/tools:$ANDROID_HOME/tools/bin:$ANDROID_HOME/platform-tools::$ANDROID_HOME/build-tools/$ANDROID_BUILD_TOOLS_VERSION

RUN wget -O tools.zip https://dl.google.com/android/repository/sdk-tools-linux-3859397.zip && \
    unzip tools.zip && rm tools.zip && \
    mkdir .android && touch .android/repositories.cfg && \
    chmod a+x -R $ANDROID_HOME && \
    chown -R root:root $ANDROID_HOME

ENV APPIUM_VERSION=1.6.5-beta \
    UDEV_REMOTE_FILE=https://raw.githubusercontent.com/M0Rf30/android-udev-rules/master/51-android.rules

RUN curl -sL https://deb.nodesource.com/setup_7.x | bash - && \
    apt-get -qqy install nodejs && \
    npm install -g appium@${APPIUM_VERSION} --no-shrinkwrap  && \
    npm cache clean && \
    apt-get remove --purge -y npm && \
    apt-get autoremove --purge -y && \
    mkdir /etc/udev/rules.d && \
    wget --no-verbose $UDEV_REMOTE_FILE -O /etc/udev/rules.d/51-android.rules && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    apt-get clean

ENV TZ="Asia/Bangkok"

RUN echo "Configure time zone to '${TZ}'" && \
    echo "${TZ}" > /etc/timezone && \
    dpkg-reconfigure --frontend noninteractive tzdata

EXPOSE 4723 5900

RUN echo y | sdkmanager --update
RUN echo y | sdkmanager "platform-tools"
RUN sdkmanager "build-tools;$ANDROID_BUILD_TOOLS_VERSION"
RUN sdkmanager "platforms;android-23"
RUN sdkmanager "system-images;android-23;google_apis;x86_64"
RUN avdmanager --verbose create avd --force --name testavd  --device 10 --package 'system-images;android-23;google_apis;x86_64'

CMD appium --log /var/log/appium.log
