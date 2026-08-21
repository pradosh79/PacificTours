# `public/build/` is committed to Git — do NOT `npm run build` on the server

This folder holds the pre-compiled CSS and JS bundles that make the site look
right. It is intentionally *not* gitignored, and Railway is configured (see
`nixpacks.toml` at the repo root) to skip `npm run build` entirely.

## Why

Custom design changes were made against the compiled output in
`assets/*.css` — they do NOT exist in the source SCSS at
`resources/sass/*.scss`. Any fresh `npm run build` regenerates these files
from the source and loses the design work.

## To make a CSS/JS change

1. Edit the source (`resources/sass/*.scss` or `resources/js/*.js`) OR the
   compiled output in `public/build/assets/*.css` directly.
2. If you edited the source, run `npm run build` locally.
3. Commit the resulting `public/build/` folder — filenames include content
   hashes (e.g. `app-Bw4O7vUZ.css`), so a new build produces new filenames
   AND updates `manifest.json` to reference them.
4. Push. Railway ships the committed files as-is; no rebuild happens.

## The long-term fix

Whoever owns the design should port the compiled-CSS tweaks back into
`resources/sass/*.scss` so `npm run build` produces the same output. Once
that's done, this folder can go back to being gitignored and Railway can
generate it normally. Until then, this arrangement keeps prod stable.
