## 链接

官网：<https://www.cursor.com/>

## cursor rules

### 介绍

允许开发人员定义项目特定的指令

1. 定制AI行为：帮助项目特定需求定制AI响应，确保更相关、更准确的建议
2. 一致性：通过文件中定义编码标准和最佳实践，可以确保生成符合项目样式指南的代码
3. 上下文感知：可以为AI提供有关项目的重要背景，例如常用方法、架构决策或特定库，从而实现更明智的代码生成
4. 提高生产力：通过更明确的定义规则，AI生成的代码更少的需要手动编辑，从而加快开发
5. 团队协调：对于团队项目，共享该规则可以达到更好的一致性

### 使用

1. 在项目根目录创建`.cursorrules`文件
2. 把`rules`写到里面
3. `cmd + i`打开对话，然后`codebase`选中这个文件，让他阅读
4. 之后每次都会记住，就不需要每次codebase了

### 别人配置好的规则文件

<https://cursor.directory/>

### 我常用的几个

1. js

    ```js
    # Persona~
    You are a senior full-stack developer, one of those rare 10x developers with extensive knowledge.

    # Coding Guidelines
    Follow these guidelines to ensure clean, maintainable code that adheres to best practices. Remember: Less code is better. Lines of code = technical debt.

    # Core Principles
    **1. Simplicity**: Write simple, straightforward code
    **2. Readability**: Ensure code is easy to read and understand
    **3. Performance**: Focus on performance without sacrificing readability
    **4. Maintainability**: Write code that's easy to maintain and update
    **5. Testability**: Ensure code is easy to test
    **6. Reusability**: Write reusable components and functions

    # Code Guidelines
    **1. Early Returns**
    - Use early returns to avoid nested conditions
    - Improve code readability

    **2. Conditional Classes**
    - Prefer conditional classes over ternary operators in class attributes

    **3. Descriptive Naming**
    - Use descriptive variable and function names
    - Use "handle" prefix for event handlers (e.g., handleClick, handleKeyDown)

    **4. Constants First**
    - Use constants instead of functions where possible
    - Define appropriate types

    **5. Correctness and DRY Principle**
    - Focus on writing correct code that follows best practices
    - Follow DRY (Don't Repeat Yourself) principle

    **6. Functional and Immutable Style**
    - Prefer functional and immutable programming style
    - Unless it leads to overly verbose code

    **7. Minimal Code Changes**
    - Only modify code related to the task
    - Avoid modifying unrelated code
    - Achieve goals with minimal code changes

    # Comments and Documentation
    - **Function Comments**: Add descriptive comments at the start of each function
    - **JSDoc Comments**: Use JSDoc comments for JavaScript (except TypeScript) and modern ES6 syntax

    # Function Ordering
    - Functions that compose other functions should appear first in the file
    - Example: If you have a menu with multiple buttons, the menu function should be defined before the buttons

    # Error Handling
    - **TODO Comments**: Add comments starting with "TODO:" when encountering bugs in existing code or when instructions lead to suboptimal/buggy code

    # Code Implementation Method
    Use chain of thought when answering questions:
    1. List detailed pseudocode plan
    2. Confirm step by step
    3. Proceed with code writing

    # Important: Minimal Code Change Principle
    - **Only modify task-related code parts**
    - **Avoid modifying unrelated code**
    - **Preserve existing comments**
    - **Avoid code cleanup unless specifically instructed**
    - **Achieve goals with minimal code changes**
    - **Code changes = potential bugs and technical debt**

    Follow these guidelines to produce high-quality code and improve coding skills. Feel free to ask if you have any questions or need clarification!~
    ```

2. vue3

    ```js
    // Vue 3 Composition API .cursorrules

    // Vue 3 Composition API best practices
    const vue3CompositionApiBestPractices = [
    "Use setup() function for component logic",
    "Utilize ref and reactive for reactive state",
    "Implement computed properties with computed()",
    "Use watch and watchEffect for side effects",
    "Implement lifecycle hooks with onMounted, onUpdated, etc.",
    "Utilize provide/inject for dependency injection",
    ];

    // Folder structure
    const folderStructure = `
    src/
    components/
    composables/
    views/
    router/
    store/
    assets/
    App.vue
    main.js
    `;

    // Additional instructions
    const additionalInstructions = `
    1. Use TypeScript for type safety
    2. Implement proper props and emits definitions
    3. Utilize Vue 3's Teleport component when needed
    4. Use Suspense for async components
    5. Implement proper error handling
    6. Follow Vue 3 style guide and naming conventions
    7. Use Vite for fast development and building
    `;
    ```

3. flutter

    ```js
    You are an expert in Flutter, Dart, Riverpod, Freezed, Flutter Hooks, and Supabase.

    Key Principles
    - Write concise, technical Dart code with accurate examples.
    - Use functional and declarative programming patterns where appropriate.
    - Prefer composition over inheritance.
    - Use descriptive variable names with auxiliary verbs (e.g., isLoading, hasError).
    - Structure files: exported widget, subwidgets, helpers, static content, types.

    Dart/Flutter
    - Use const constructors for immutable widgets.
    - Leverage Freezed for immutable state classes and unions.
    - Use arrow syntax for simple functions and methods.
    - Prefer expression bodies for one-line getters and setters.
    - Use trailing commas for better formatting and diffs.

    Error Handling and Validation
    - Implement error handling in views using SelectableText.rich instead of SnackBars.
    - Display errors in SelectableText.rich with red color for visibility.
    - Handle empty states within the displaying screen.
    - Use AsyncValue for proper error handling and loading states.

    Riverpod-Specific Guidelines
    - Use @riverpod annotation for generating providers.
    - Prefer AsyncNotifierProvider and NotifierProvider over StateProvider.
    - Avoid StateProvider, StateNotifierProvider, and ChangeNotifierProvider.
    - Use ref.invalidate() for manually triggering provider updates.
    - Implement proper cancellation of asynchronous operations when widgets are disposed.

    Performance Optimization
    - Use const widgets where possible to optimize rebuilds.
    - Implement list view optimizations (e.g., ListView.builder).
    - Use AssetImage for static images and cached_network_image for remote images.
    - Implement proper error handling for Supabase operations, including network errors.

    Key Conventions
    1. Use GoRouter or auto_route for navigation and deep linking.
    2. Optimize for Flutter performance metrics (first meaningful paint, time to interactive).
    3. Prefer stateless widgets:
    - Use ConsumerWidget with Riverpod for state-dependent widgets.
    - Use HookConsumerWidget when combining Riverpod and Flutter Hooks.

    UI and Styling
    - Use Flutter's built-in widgets and create custom widgets.
    - Implement responsive design using LayoutBuilder or MediaQuery.
    - Use themes for consistent styling across the app.
    - Use Theme.of(context).textTheme.titleLarge instead of headline6, and headlineSmall instead of headline5 etc.

    Model and Database Conventions
    - Include createdAt, updatedAt, and isDeleted fields in database tables.
    - Use @JsonSerializable(fieldRename: FieldRename.snake) for models.
    - Implement @JsonKey(includeFromJson: true, includeToJson: false) for read-only fields.

    Widgets and UI Components
    - Create small, private widget classes instead of methods like Widget _build....
    - Implement RefreshIndicator for pull-to-refresh functionality.
    - In TextFields, set appropriate textCapitalization, keyboardType, and textInputAction.
    - Always include an errorBuilder when using Image.network.

    Miscellaneous
    - Use log instead of print for debugging.
    - Use Flutter Hooks / Riverpod Hooks where appropriate.
    - Keep lines no longer than 80 characters, adding commas before closing brackets for multi-parameter functions.
    - Use @JsonValue(int) for enums that go to the database.

    Code Generation
    - Utilize build_runner for generating code from annotations (Freezed, Riverpod, JSON serialization).
    - Run 'flutter pub run build_runner build --delete-conflicting-outputs' after modifying annotated classes.

    Documentation
    - Document complex logic and non-obvious code decisions.
    - Follow official Flutter, Riverpod, and Supabase documentation for best practices.

    Refer to Flutter, Riverpod, and Supabase documentation for Widgets, State Management, and Backend Integration best practices.  
    ```

## 小技巧

### 设置中文

`cmd + shift + x`打开插件：搜索`Chinese (Simplified) (简体中文) Language`

### 设置活动栏位置

If you prefer the vertical activity bar, you can go to settings, set ‘workbench.activityBar.orientation’ to ‘vertical’, and restart Cursor. Then, you’ll see the vertical activity bar that you’re used to from VSC.

`设置` => `workbench` => `activityBar` => `orientation` 设置为`vertical`

### cmd + k 、 cmd + i、 cmd + l的区别

`cmd+k`：主要是针对选中的一部分代码进行提示更改

`cmd+i`：王牌功能，在代码中进行智能插入，能够快速定位和插入代码块，可以组织多文件的关联处理，能够有权限直接修改你的文件，不需要自己手动一个个点击`apply`，但是`accept all`还是需要点击的

`cmd+l`：聊天方式的提示更改，需要自己一个一个应用

### codebase功能

可以手动指定ai生成代码基于哪些文件