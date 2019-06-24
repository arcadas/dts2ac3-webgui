#!/bin/bash
cd "${0%/*}";
whoami;
./mkvdts2ac3.sh -n $1 > convert.log;
rm -f ./convert.inp
