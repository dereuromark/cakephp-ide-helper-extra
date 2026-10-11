import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'cakephp-ide-helper-extra',
  description: 'Additional PhpStorm metadata tasks for CakePHP IdeHelper.',
  base: '/cakephp-ide-helper-extra/',
  cleanUrls: true,
  lastUpdated: true,
  head: [['link', { rel: 'icon', type: 'image/svg+xml', href: '/cakephp-ide-helper-extra/favicon.svg' }]],
  themeConfig: {
    logo: '/logo.svg',
    nav: [
      { text: 'Installation', link: '/guide/installation' },
      { text: 'Getting started', link: '/guide/getting-started' },
      { text: 'Tasks', link: '/reference/tasks' },
      { text: 'IdeHelper docs', link: 'https://dereuromark.github.io/cakephp-ide-helper/' },
    ],
    sidebar: [{ text: 'Guide', items: [
      { text: 'Installation', link: '/guide/installation' },
      { text: 'Getting started', link: '/guide/getting-started' },
    ] }, { text: 'Reference', items: [
      { text: 'Tasks and configuration', link: '/reference/tasks' },
      { text: 'Legacy icon task', link: '/reference/icons' },
      { text: 'Contributing', link: '/reference/contributing' },
    ] }],
    search: { provider: 'local' },
    socialLinks: [{ icon: 'github', link: 'https://github.com/dereuromark/cakephp-ide-helper-extra' }],
    editLink: { pattern: 'https://github.com/dereuromark/cakephp-ide-helper-extra/edit/master/docs/:path' },
    footer: { message: 'Released under the MIT License.' },
  },
})
