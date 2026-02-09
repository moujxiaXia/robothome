# 将代码上传到 GitHub

## 第一步：在 GitHub 上新建仓库

1. 打开 [https://github.com/new](https://github.com/new)
2. **Repository name** 填写：`robothome`（或你喜欢的名字）
3. **Description** 可选：`机器人之家 LAMP 网站`
4. 选择 **Public**
5. **不要**勾选 "Add a README file"、"Add .gitignore"（本地已有）
6. 点击 **Create repository**

## 第二步：在本地添加远程并推送

创建好仓库后，GitHub 会显示仓库地址，形如：

- HTTPS: `https://github.com/你的用户名/robothome.git`
- SSH: `git@github.com:你的用户名/robothome.git`

在项目目录 `e:\github\robothome` 下打开终端，执行（把下面的地址换成你的仓库地址）：

```bash
git remote add origin https://github.com/你的用户名/robothome.git
git branch -M main
git push -u origin main
```

若 GitHub 提示登录，按页面说明用浏览器或 Personal Access Token 完成认证即可。

## 可选：设置你的 Git 用户名和邮箱

若希望提交记录显示你的名字和邮箱，可执行（仅需设置一次）：

```bash
git config --global user.name "你的名字"
git config --global user.email "你的邮箱@example.com"
```

之后新的提交会使用该信息；当前已提交的代码不受影响，可直接推送。
