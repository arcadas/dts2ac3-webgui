# MKV DTS to AC3 Converter with Web GUI

Requirements: linux/unix, webserver (NginX, Apache), PHP5/7, mkvmerge, mkvextract, mkvinfo, ffmpeg, rsync, perl

NginX config:

```nginx
location / {
            try_files $uri $uri/ /index.php;
}
```

Set write permission for cache, log and scripts

```sh
chmod a+w cache
chmod a+w log
chmod a+x dts2ac3.sh
chmod a+x mkvdts2ac3.sh
```

Further reading: \
[Running Docker Containers as Current Host User](https://jtreminio.com/blog/running-docker-containers-as-current-host-user/)

Download and copy the following file into the root:
<https://github.com/JakeWharton/mkvdts2ac3/blob/master/mkvdts2ac3.sh> (Version: 1.6.0)

Rename .config.php to config.php and update the config variables.

Click [ SCAN ALL ] link, it will take some time at first time, after click the [ LIST ] link.

Tested maximum 1000 mkv.
Do not use in production environment, only in local network!
