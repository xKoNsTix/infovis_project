#Before WP

#!/bin/sh
npx sass ./src/sass/style.scss ./dist/style.css
cp ./src/index.php ./dist/
cp ./src/fetch_into_db.php ./dist/
cp ./src/fetch_sensors.php ./dist/
cp ./src/functions.php ./dist/
cp robots.txt ./dist/
cp ./src/save_daily_total.php ./dist/
cp ./src/7_days.php ./dist/
cp ./src/7DayChart.php ./dist/7DayChart.php
cp ./src/rawstats.php ./dist/rawstats.php
cp ./src/currentDayChart.php ./dist/currentDayChart.php
cp ./src/global.php ./dist/global.php
cp ./src/dailyChart.php ./dist/dailyChart.php
cp ./src/dailyCurrentChart.php ./dist/dailyCurrentChart.php
cp ./src/storyTelling.php ./dist/storyTelling.php




#cp ./src/favicons/*.* ./dist/

npx esbuild src/js/script.js --bundle --outfile=./dist/script.js  --minify




#After WP
# px sass ./src/sass/style.scss ./public/wp-content/themes/aaron/style.css
# cp ./src/favicons/*.* ./public/wp-content/themes/aaron
# cp ./src/php/*.* ./public/wp-content/themes/aaron
# cp -R./src/images ./public/wp-content/themes/aaron/images
# cp ./src/wordpress/*.* ./public/wp-content/themes/aaron
# cp -R ./src/fonts ./public/wp-content/themes/aaron/fonts
# npx esbuild ./src/js/main.js --bundle --outfile=./public/wp-content/themes/aaron/js/main.js  --minify
