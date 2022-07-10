read -p "Commit message: " msg
git add .
git commit -m "${msg}"
git push
read  -n 1 -p "Press any key to end..."