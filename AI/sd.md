## 大模型

### 底模/主模（大模型）

风格导向

### VAE模型

滤镜

潜空间到像素空间的桥梁（编码 & 解码）

### Lora模型

修改底模的风格

```
<lora:wlqc_20230924:1>
```

权重一般在0.5-0.8之间，不要超过1


## 提示词

一个小括号代表1.1的比例，或者直接写，不能超过2，一般在1.2到1.7之间

> (3d手办角色: 1.5)

### 正面词

结构

1. 质量（基本都是可以通用）
2. 主体
3. 元素
4. 风格

```
# 质量

杰作，高质量，超细节，完美的精度，高分辨率，大师级的，4k手办画面
Masterpiece, high quality, ultra-detailed, perfect precision, high resolution, master-level, 4k figure artwork

# 主体

(3d手办角色: 1.5)，(绿色的头发: 1.5)，长裙，机械化的，金属配饰，梅花在森林里，树，草，植物，斑驳的阳光，明亮的
(3D figure character: 1.5), (green hair: 1.5), long dress, mechanized, metal accessories, plum blossoms in the forest, trees, grass, plants, patchy sunlight, bright

# 元素

国风的3d手办元素
Elements of traditional Chinese style in 3D handcrafted figures

# 风格

3d手办立体角色风格
3D action figure three-dimensional character style


# 示例

Masterpiece, high quality, ultra-detailed, perfect precision, high resolution, master-level, 4k figure artwork，(3D figure character: 1.5), (green hair: 1.5), long dress, mechanized, metal accessories, plum blossoms in the forest, trees, grass, plants, patchy sunlight, bright，Elements of traditional Chinese style in 3D handcrafted figures，3D action figure three-dimensional character style
```

### 反向词

通用模板

```
NSFW,EasyNegative,badhandv4,ng_deepnegative_v1_75t,16-token-negative-deliberate-neg,bad_prompt_version2,ng_deepnegative_v1_75t,badhandv4 (worst quality:2),(low quality:2),(normal quality:2),lowres,bad anatomy,bad hands,normal quality,((monochrome)),((grayscale)),nsfw,nsfw
```

## 采样方法（Sampler）

一般用`DPM++ 2M`

## 调度器（Schedule type）

配合采样方法`DPM++ 2M`的话，一定要选择`Karras`

## 迭代步数

一般在20-50之间，30-40合适

 