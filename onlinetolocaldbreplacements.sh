#!/bin/bash

# Repleacement Script for DB Publish Eval Lime Survey

CURRENTDATETIME=$(date +"%y%m%d_%H-%M-%S")
echo "Name file to read"

read FILEPATH

echo ""

searchURL="https:\/\/forschung.veitstephan.digital\/diss\/fmapp\/beta\/"
replaceURL="http:\/\/localhost:8888\/foodemapp\/cake\/"

tempFilePath="${FILEPATH}.tmp.sql"

echo "Start Search and Replace for standard URLs"

echo ""

sed  "s/$searchURL/$replaceURL/g" $FILEPATH > $tempFilePath || printf "\n\nERROR 1St SED F A I L E D !!! \n\n"

echo "Searched for ${searchURL}"
echo "Replaced with ${replaceURL}"
echo "Standard URLs replaced succesfully"
echo "Created TMP-File "

echo ""

echo "Replacing IMG URLs next"

searchIMGPaths="\/diss\/fmapp\/beta\/webroot\/eval\/upload\/surveys\/612158\/images\/"
replaceIMGPaths="\/foodemapp\/cake\/webroot\/eval\/upload\/surveys\/612158\/images\/"

sed  "s/$searchIMGPaths/$replaceIMGPaths/g" $tempFilePath > "${FILEPATH}.publish.${CURRENTDATETIME}.sql" || printf "\n\nERROR 2nd SED F A I L E D !!! \n\n\tCheck Output if TMP-File was not found (1. SED failed already) or if secodn SED failed\n\n"

rm $tempFilePath

echo "TMP-File Deleted"

echo ""

echo "Searched for ${searchIMGPaths}"
echo "Replaced with ${replaceIMGPaths}"
echo "IMG URLs replaced succesfully"

echo ""

echo "Search and Replace completed, have a nice day"
