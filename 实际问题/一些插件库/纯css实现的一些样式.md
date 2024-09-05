1. loading

> https://juejin.cn/post/7037036742985121800#heading-1\

2. 进度条

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      .progress-bar {
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        height: 20px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        position: relative;
      }

      .progress-bar-fill {
        height: 100%;
        background-color: #76c7c0;
        border-radius: inherit;
        transition: width 0.4s ease;
        position: relative;
      }

      .progress-text {
        position: absolute;
        width: 100%;
        text-align: center;
        color: white;
        font-weight: bold;
        line-height: 20px;
      }
    </style>
  </head>
  <body>
    <div class="progress-bar">
      <div class="progress-bar-fill" style="width: 70%">
        <span class="progress-text">70%</span>
      </div>
    </div>
  </body>
</html>
```
