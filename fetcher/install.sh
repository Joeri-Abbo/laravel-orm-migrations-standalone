#!/usr/bin/env bash
FILE=config.json
DUMPS=dumps
if test -f "$FILE"; then
  echo "Do you wish to overwrite the existing config?"
  select yn in "Yes" "No"; do
    case $yn in
    Yes)
      echo "Removing old config..."
      rm $FILE
      break
      ;;
    No)
      echo "exiting..."
      exit
      ;;
    esac
  done
fi
echo -n "Please enter repo root url: "
read -r url

#$url
array=()
while IFS= read -r -p "Tables to automatic fetch?(end with an empty line): " line; do
  [[ $line ]] || break # break if line is empty
  array+=("$line")
done

printf '%s\n' "Items read:"
printf '  «%s»\n' "${array[@]}"

printf "{\""url\"":\"${url}\",\""tables\"":${wack}}" >$FILE
