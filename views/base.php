<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Decay</title>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/htmx.org@2.0.4"></script>
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            @keyframes fade-in {
                from { opacity: 0; }
            }

            @keyframes fade-out {
                to { opacity: 0; }
            }

            @keyframes slide-up {
                from { transform: translateY(-90px); }
            }

            @keyframes slide-down {
                to { transform: translateY(90px); }
            }

            <?php foreach ($movies as $movie) : ?>
                ::view-transition-old(title-<?= $movie->id ?>) {
                    animation: 180ms cubic-bezier(0.4, 0, 1, 1) both fade-out,
                    600ms cubic-bezier(0.4, 0, 0.2, 1) both slide-down;
                }

                ::view-transition-new(title-<?= $movie->id ?>) {
                    animation: 420ms cubic-bezier(0, 0, 0.2, 1) 90ms both fade-in,
                    600ms cubic-bezier(0.4, 0, 0.2, 1) both slide-up;
                }
            <?php endforeach ?>
        </style>
    </head>
    <body
        hx-boost="true"
        hx-swap="transition:true show:none"
        class="antialiased bg-slate-950 bg-center bg-repeat font-mono max-w-[125rem] mx-auto text-slate-300"
        style="background-image: url(/assets/dots.svg)"
    >
        <main class="p-8 pb-16 lg:p-0">
            <?= $content ?>
        </main>
    </body>
</html>