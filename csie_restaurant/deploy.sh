#!/usr/bin/env sh
# 當發生錯誤時終止腳本運行
set -e
# 打包
npm run build --modern
# 移動至到打包後的dist目錄 
cd dist
git init
git add -A
git commit -m 'deploy'
# 部署到 https://github.com/guyleaf/csie_restaurant.git 分支為 gh-pages
git push -f https://github.com/guyleaf/csie_restaurant.git master:gh-pages
cd -
