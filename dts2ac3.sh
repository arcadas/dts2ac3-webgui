#!/bin/bash
cd "${0%/*}";
whoami;
./mkvdts2ac3.sh -f -n $1 > log/convert.log;
rm -f ./log/convert.inp
