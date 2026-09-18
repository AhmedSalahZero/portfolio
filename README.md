# Developer Portfolio — Vite + Vue 3

A static, dark-themed developer portfolio. Content lives in TypeScript files under `src/data/` — no database or backend.

## Tech stack

| Layer    | Technology                                      |
| -------- | ----------------------------------------------- |
| App      | Vue 3 (`<script setup>`), TypeScript, Vite      |
| Routing  | Vue Router (SPA, History mode)                  |
| State    | Pinia                                           |
| Styling  | Tailwind CSS v4                                 |
| Hosting  | Netlify (SPA redirects + Netlify Forms)         |

## Getting started

```bash
npm install
npm run dev
```

Open the printed local URL (usually `http://localhost:5173`).

```bash
npm run build      # production build → dist/
npm run preview    # preview the production build locally
```

## Editing content

Update the files in `src/data/` and rebuild:

| Section        | File                                      |
| -------------- | ----------------------------------------- |
| Name / bio / socials / stats / CV | [`src/data/profile.ts`](src/data/profile.ts) |
| Skills         | [`src/data/skills.ts`](src/data/skills.ts) |
| Projects       | [`src/data/projects.ts`](src/data/projects.ts) |
| Experience     | [`src/data/experiences.ts`](src/data/experiences.ts) |

Place the CV PDF at `public/cv/ahmed-salah-cv.pdf` (or change `cv_url` in the profile file).

## Deploy on Netlify

1. Push this repo to GitHub (or GitLab / Bitbucket).
2. In Netlify: **Add new site → Import an existing project**.
3. Build settings are already in `netlify.toml`:
   - Build command: `npm run build`
   - Publish directory: `dist`
4. After the first deploy, open **Forms** in the Netlify dashboard. Submissions from the contact form appear there and can be emailed to you.

SPA routes such as `/projects/mnjz` are rewritten to `index.html` by the redirect in `netlify.toml`.

After you have a live domain, replace the relative URLs in `public/sitemap.xml` and the Open Graph tags in `index.html` with the full site origin.

## Contact form

The form posts to **Netlify Forms** (form name: `contact`, honeypot field: `website`). Delivery only works on a Netlify deploy — local preview still validates the UI.

## License

MIT — feel free to adapt this for your own portfolio.
