# Тестове завдання для RedLab

https://djinni.co/jobs/578622-wordpress-developer/

В репозиторії плагін який реалізовує тестове завдання. Жодних правок в тему вносити не потрібно.

Також додано Знімок контенту - [./content.xml](./content.xml)

1. Плагін створює окремий `post_type` `event` та таксономію `location` для нього.
2. Для виводу `event` можна використовувати вбудований `query loop` блок.
3. Для фільтрації створено два додаткові блоки: `Date filter` та `Location filter` які можна додати виключно в
	 межах `query loop` блоку.

## Порядок розгортання

1. Розгорніть WordPress.
2. Встановіть плагін з цього репозиторію.
3. Імпортуйте контент з файлу [./content.xml](./content.xml).


## Початок розробки

Для внесення змін в плагін потрібно налаштувати робоче середовище.

1. Встановити node.js.
2. В теці з плагіном виконати `npm ci`, щоб встановити залежності.
3. В теці з плагіном виконати `npm start`, щоб запустити середовище розробки.
Детальніше [@wordpress/create-block ](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/#available-commands-in-the-scaffolded-project)
