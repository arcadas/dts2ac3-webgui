# MKV DTS to AC3 Converter with Web GUI

Requirements: linux/unix, webserver (NginX, Apache), PHP5/7, ffmpeg.

NginX config:

```
location / {
            try_files $uri $uri/ /index.php;
}
```

Download and copy the following file into the root:
<https://github.com/JakeWharton/mkvdts2ac3/blob/master/mkvdts2ac3.sh> (Version: 1.6.0)

Rename .config.php to config.php and update the config variables.

Click [ SCAN ALL ] link, it will take some time at first time, after click the [ LIST ] link.

Tested maximum 1000 mkv.
Do not use in production environment, only in local network!
