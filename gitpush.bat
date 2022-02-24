ECHO on
git config user.name "medhere"
git config user.email "edhere.michael@gmail.com"
git init
git add --all
set /P comment="Enter date or comment: "
git commit -m "New Commit - %comment%"
set /P url="Enter git:  "
git branch -M master
git remote add origin https://github.com/medhere/%url%.git
git push -u origin master
git remote rm origin
PAUSE