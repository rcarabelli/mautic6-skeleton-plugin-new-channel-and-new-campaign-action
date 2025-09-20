# Mautic 6 Skeleton: New Channel (menu) + New Campaign Action

**A working, minimal plugin** that shows how to:
- Add a **Channel** menu item (under the left sidebar → Channels) with a Twig page rendered inside Mautic.
- Register a **custom Campaign Action** (node in the Campaign Builder) with its own Symfony FormType and execution handler.

This repo exists because wiring **both** things in **Mautic 6** is trickier than expected. Here you’ll find a clean reference implementation plus a repeatable path to **rename and reuse** the skeleton for your own plugins.

---

## Why this is harder than it looks in Mautic 6

Mautic plugin development touches **five subsystems** at once:

1. **Symfony Bundle lifecycle**  
   Your plugin is a bundle that must expose a proper **container extension**. If the container can’t see your services or Twig paths at the right time, things *look* installed but nothing shows up.

2. **Mautic Plugin Config contract**  
   `Config/config.php` is the heart: it wires **menu**, **routes**, **campaign events**, and **services**. One wrong key → silent failure (no menu, no action).

3. **Twig namespacing in M6**  
   Mautic 6 expects **namespaced Twig paths**. You must **prepend** your views into Twig’s config (in your `DependencyInjection` extension) and reference them like `@YourBundle/...`.

4. **Campaign Builder API**  
   A custom action needs:
   - an **action key**,
   - a **builder label/description** (translated),
   - a **FormType** (registered as a service with alias),
   - and a **runtime event name** to actually execute.  
   Miss one link and the node either doesn’t appear or never fires.

5. **Aggressive caching/discovery**  
   After any change:  
   ```bash
   php bin/console cache:clear --no-warmup && php bin/console cache:warmup
   ```
This skeleton gets all of that right—then stays out of your way.

---

## What you get

✅ Channel menu item under Channels → Test Channel
✅ Route + Controller with proper delegateView() and active link highlight
✅ Namespaced Twig views compatible with Mautic 6
✅ Campaign Action (“Send Test Action”) with FormType and execution handler
✅ Translations for labels/description
🧩 A tidy codebase you can rename to your own bundle in minutes

---

## File layout
```bash
plugins/AcmeSkeletonBundle/
├── AcmeSkeletonBundle.php
├── Config/config.php
├── Controller/ChannelController.php
├── DependencyInjection/AcmeSkeletonExtension.php
├── EventListener/CampaignSubscriber.php
├── Form/Type/TestActionType.php
├── Resources/views/Channel/index.html.twig
└── Translations/en_US/messages.ini
```

# Roles:
- Config/config.php – Menu, routes, services, campaign events (on_build + execution).
- DependencyInjection/AcmeSkeletonExtension.php – Prepends Twig namespace: @AcmeSkeletonBundle.
- ChannelController.php – Renders the Channel page via delegateView() and sets activeLink to #skeleton.menu.channel.
- CampaignSubscriber.php – Registers the action in the builder and handles execution.
- TestActionType.php – Symfony FormType shown in the action’s sidebar.
- index.html.twig – Minimal content page extending Mautic’s chrome.
- messages.ini – Labels and descriptions.

## Quick install (on any Mautic 6)

1. Copy to your Mautic:
```bash
/path/to/mautic/plugins/AcmeSkeletonBundle
```

2. Permissions (typical cPanel/AlmaLinux):
```bash
cd /path/to/mautic
find plugins/AcmeSkeletonBundle -type d -exec chmod 755 {} \;
find plugins/AcmeSkeletonBundle -type f -exec chmod 644 {} \;
```

3. Clear & warm cache:
```bash
php bin/console cache:clear --no-warmup && php bin/console cache:warmup
```

4. (Optional) Sanity checks:
```bash
php bin/console lint:twig plugins/AcmeSkeletonBundle
php bin/console debug:container | grep -i acme | grep subscriber
```

5. Open Mautic:
- Sidebar → Channels → Test Channel (page should render)
- Campaign Builder → Actions → Send Test Action (node should appear)

## Reusing this for your own plugin (rename guide)

Let’s say your new plugin should be named WABAChannelBundle under namespace
MauticPlugin\WABAChannelBundle.

Replace strings carefully: AcmeSkeletonBundle → WABAChannelBundle,
AcmeSkeleton → WABAChannel, skeleton → waba.

A) Rename directories & files

From the repo root (where plugins/AcmeSkeletonBundle lives):

cd plugins
cp -a AcmeSkeletonBundle WABAChannelBundle

# Inside the new bundle, rename namespaces & tokens in PHP/Twig/INI
cd WABAChannelBundle
grep -RIl 'AcmeSkeletonBundle\|AcmeSkeleton\|skeleton' . \
| xargs sed -i \
  -e 's/MauticPlugin\\AcmeSkeletonBundle/MauticPlugin\\WABAChannelBundle/g' \
  -e 's/AcmeSkeletonBundle/WABAChannelBundle/g' \
  -e 's/AcmeSkeleton/WABAChannel/g' \
  -e 's/skeleton/waba/g'

B) Adjust menu keys / routes / labels

Open Config/config.php and review:

Menu key: skeleton.menu.channel → waba.menu.channel

Route name & path: skeleton_channel_index → waba_channel_index (and /waba/channel)

Service IDs: acme.skeleton.campaign.subscriber → waba.channel.campaign.subscriber

Form alias: skeleton_test_action → waba_send_template (or similar)

Translation strings in Translations/.../messages.ini

C) Fix the controller and twig:

activeLink should match your menu key with a leading #, e.g. #waba.menu.channel.

Twig extends: keep @MauticCore/Default/content.html.twig.

Twig namespace in DependencyInjection/*Extension.php: path key must be WABAChannelBundle.

D) Clear cache and verify
php bin/console cache:clear --no-warmup && php bin/console cache:warmup
php bin/console lint:twig plugins/WABAChannelBundle
php bin/console debug:container | grep -i waba | grep subscriber


Open Mautic and test.

Troubleshooting

Menu not visible: check parent is mautic.core.channels, user perms, cache cleared.

Twig not found: confirm the prepend Twig path in your *Extension.php and run lint:twig.

Action missing in builder: check events → campaign → mautic.campaign.on_build entry and your FormType service alias.

Action never executes: ensure the event name in onCampaignBuild exactly matches the subscribed one in getSubscribedEvents(); add logging; clear cache.

Sidebar highlight wrong: activeLink must be #<your.menu.key>.

Versioning

Tag releases:

git tag -a v1.0.0 -m "Initial skeleton: channel + campaign action for Mautic 6"
git push origin v1.0.0

License

MIT (or adapt to your needs).

Credits

Built from a real, production-tested implementation used to ship a WABA channel and campaign action on Mautic 6. Contributions welcome!


---

# 2) Publish to GitHub (using your SSH key)

You said the repo *destination* is:



https://github.com/rcarabelli/mautic6-skeleton-plugin-new-channel-and-new-campaign-action


The **SSH remote** for that is:



git@github.com
:rcarabelli/mautic6-skeleton-plugin-new-channel-and-new-campaign-action.git


You’re already in the plugin directory on AlmaLinux:
`/home/cats/public_html/marketautomation/plugins/AcmeSkeletonBundle`

Run this once:

```bash
# 0) (Optional) set Git identity for this repo
git config user.name "Renato Carabelli"
git config user.email "rcarabelli@gmail.com"

# 1) Initialize the repo at the plugin folder
git init
git add .
git commit -m "feat: Mautic 6 skeleton plugin (new Channel + new Campaign Action)"

# 2) Create and switch to main branch
git branch -M main

# 3) Add the GitHub remote via SSH
git remote add origin git@github.com:rcarabelli/mautic6-skeleton-plugin-new-channel-and-new-campaign-action.git

# 4) Push
git push -u origin main

# 5) Tag a release (optional but recommended)
git tag -a v1.0.0 -m "Initial community release"
git push origin v1.0.0


Your SSH key shows read/write and was recently used, so the push should work.

Optional niceties (add now, push again)

.gitignore at repo root (handy defaults):

.DS_Store
Thumbs.db
*.log
vendor/
.idea/
.vscode/


LICENSE (MIT):

MIT License

Copyright (c) 2025 …

Permission is hereby granted, free of charge, to any person obtaining a copy…
[standard MIT text]


Then:

git add README.md .gitignore LICENSE
git commit -m "docs: add README, license and gitignore"
git push

