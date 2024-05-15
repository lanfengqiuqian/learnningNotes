### useContextMenu.ts

```ts
import { onMounted, onUnmounted, ref } from 'vue';

export default function (containerRef) {
  const showMenu = ref(false);
  const x = ref(0);
  const y = ref(0);
  const handleContextMenu = (e) => {
    e.preventDefault();
    e.stopPropagation();
    showMenu.value = true;
    x.value = e.clientX;
    y.value = e.clientY;
  };
  function closeMenu() {
    showMenu.value = false;
  }
  onMounted(() => {
    const div = containerRef.value;
    div.addEventListener('contextmenu', handleContextMenu);
    window.addEventListener('click', closeMenu, true);
    window.addEventListener('contextmenu', closeMenu, true);
  });
  onUnmounted(() => {
    const div = containerRef.value;
    div.removeEventListener('contextmenu', handleContextMenu);
    window.removeEventListener('click', closeMenu, true);
    window.removeEventListener('contextmenu', closeMenu, true);
  });
  return {
    showMenu,
    x,
    y,
  };
}

```


### index.vue

```html
<template>
  <div ref="containerRef">
    <slot></slot>
    <Teleport to="body">
      <Transition
        @before-enter="handleBeforeEnter"
        @enter="handleEnter"
        @after-enter="handleAfterEnter"
      >
        <div
          v-if="showMenu"
          class="context-menu"
          :style="{ left: x + 'px', top: y + 'px' }"
        >
          <div class="menu-list">
            <!-- 添加菜单的点击事件 -->
            <div
              v-for="item in menu"
              :key="item.label"
              class="menu-item"
              @click="handleClick(item)"
            >
              <div class="content">
                {{ item.label }}
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
  import { ref } from 'vue';
  import useContextMenu from './useContextMenu';

  const props = defineProps({
    menu: {
      type: Array,
      default: () => [],
    },
  });
  const containerRef = ref(null);
  const emit = defineEmits(['select']);
  const { x, y, showMenu } = useContextMenu(containerRef);
  // 菜单的点击事件
  function handleClick(item) {
    // 选中菜单后关闭菜单
    showMenu.value = false;
    // 并返回选中的菜单
    emit('select', item);
  }

  function handleBeforeEnter(el) {
    el.style.height = 0;
  }

  function handleEnter(el) {
    el.style.height = 'auto';
    const h = el.clientHeight;
    el.style.height = 0;
    requestAnimationFrame(() => {
      el.style.height = `${h}px`;
      el.style.transition = '.5s';
    });
  }

  function handleAfterEnter(el) {
    el.style.transition = 'none';
  }
</script>

<style scoped lang="less">
  .context-menu {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;

    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 999;
    .menu-list {
      .menu-item {
        &:hover {
          background-color: #eee;
          color: #ab3a23;
        }
        padding: 0 10px;
        .content {
          padding: 10px 20px;
          border-bottom: 1px solid #ccc;
          font-size: 12px;
          cursor: pointer;
        }
        &:last-child .content {
          border-bottom-width: 0;
        }
      }
    }
  }
</style>
```