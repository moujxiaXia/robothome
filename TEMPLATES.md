# PHP 模板供选择

项目支持下载多套免费 PHP/HTML 模板到本地 `templates/` 目录，供参考或选型后接入「机器人之家」。

---

## 怎样看这些模板的效果？

### 方式一：一键预览（推荐）

- **Windows**：双击运行 **`preview-templates.bat`**  
  会自动用浏览器打开所有 HTML 模板；若选 y，会启动 PHP 服务并打开 php-bootstrap-basic。
- **Linux / macOS**：在项目根目录执行 `chmod +x preview-templates.sh` 后运行 `./preview-templates.sh`。

### 方式二：手动打开

| 模板 | 怎么看效果 |
|------|------------|
| **startbootstrap-landing** | 用浏览器直接打开文件：`templates/startbootstrap-landing/dist/index.html`（双击或在地址栏填本地路径） |
| **startbootstrap-modern-business** | 打开 `templates/startbootstrap-modern-business/dist/index.html`，左侧导航可点「About」「Blog」「Contact」「Pricing」等子页 |
| **startbootstrap-clean-blog** | 打开 `templates/startbootstrap-clean-blog/dist/index.html`，可再打开同目录下 `about.html`、`post.html`、`contact.html` |
| **php-bootstrap-basic** | 需要 PHP。在终端进入 `templates/php-bootstrap-basic`，执行 `php -S localhost:8081`，浏览器访问 **http://localhost:8081** |

HTML 模板用浏览器打开本地 `.html` 文件即可；PHP 模板必须用 `php -S` 或 Apache 等跑起来再访问。

## 一键下载模板（在项目根目录执行）

**Windows (PowerShell):**
```powershell
New-Item -ItemType Directory -Path templates -Force
Set-Location templates
git clone --depth 1 https://github.com/matthewspear/PHP-Template.git php-bootstrap-basic
git clone --depth 1 https://github.com/StartBootstrap/startbootstrap-landing-page.git startbootstrap-landing
git clone --depth 1 https://github.com/StartBootstrap/startbootstrap-modern-business.git startbootstrap-modern-business
```

**Linux / macOS / WSL:**
```bash
mkdir -p templates && cd templates
git clone --depth 1 https://github.com/matthewspear/PHP-Template.git php-bootstrap-basic
git clone --depth 1 https://github.com/StartBootstrap/startbootstrap-landing-page.git startbootstrap-landing
git clone --depth 1 https://github.com/StartBootstrap/startbootstrap-modern-business.git startbootstrap-modern-business
```

> 说明：`templates/` 已加入 `.gitignore`，不会推送到 GitHub；在新环境拉取代码后可按上面命令重新下载模板。

---

## 模板说明

| 模板 | 类型 | 入口 / 预览 |
|------|------|-------------|
| **php-bootstrap-basic** | PHP + HTML/CSS，header/footer 结构 | 在 `templates/php-bootstrap-basic` 下运行 `php -S localhost:8081`，打开 http://localhost:8081 |
| **startbootstrap-landing** | 单页落地页（Bootstrap 5） | 浏览器打开 `templates/startbootstrap-landing/dist/index.html` |
| **startbootstrap-modern-business** | 多页企业站（首页、关于、博客、联系等） | 打开 `templates/startbootstrap-modern-business/dist/index.html`，再点导航看 about、blog、contact、pricing 等 |
| **startbootstrap-clean-blog** | 博客风（首页、关于、文章、联系） | 打开 `templates/startbootstrap-clean-blog/dist/index.html`，同目录还有 about.html、post.html、contact.html |

- **php-bootstrap-basic**：与当前项目结构类似，可参考其布局与样式集成到现有 PHP。
- **startbootstrap-landing**：适合做首页/落地页参考，将 `dist/` 内 CSS/JS/图复制到 `assets/` 后改首页模板。
- **startbootstrap-modern-business**：多栏目齐全，可参考其关于、博客、联系等页面布局，对应到现有新闻/技术/博客/关于。

下载完成后，`templates/` 下会有一份 `README.md`，内有更详细的使用与接入说明。

---

## 更多模板来源

- [StartBootstrap 主题](https://startbootstrap.com/themes)
- [PHP Website Templates](https://phpwebsitetemplates.com/)
- GitHub 搜索：`php template bootstrap`、`html template free`
