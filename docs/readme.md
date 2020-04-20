## CakePHP IdeHelper Extras

### Existing tasks
Follow the main documentation on how to add them.

#### Tools.FormatHelper::icons()

and Fontawesome v4 or v5:
- FormatIconFontAwesome4Task
- FormatIconFontAwesome5Task


### Add your own task

The idea of this repository is to provide a way to collect useful tasks and addons where adding them into the main
plugin is not feasable. Always first check, and then add it here.

The downside of adding it here is a missing constraint towards your plugin version, and that it can lead
to accidental BC breaks.

#### Contributing guidelines
If you want to add your Task here for example:
- src/[PluginName]/[Type]/Task/[ClassNameDetails]Task.php
- test case along with it
- test should also have smoke test of the functionality if possible (to be alerted about BC breaks)
- PR with green checks

You are accepting to be responsible to keep the API of your specific plugin intact.
Fails/Regressions should be handled by you if possible.

A TravisCI cronjob on the repo will check daily status here.
