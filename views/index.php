<section class="gap-12 flex flex-col overflow-clip lg:grid lg:grid-cols-[250px_1fr]">
    <ul class="gap-2 inline-flex overflow-x-scroll lg:grid lg:grid-cols-2 lg:overflow-visible lg:pl-1 lg:py-1">
        <?php foreach ($movies as $movie): ?>
            <li>
                <a
                    class="h-full inline-flex object-cover w-24 lg:w-full [&.htmx-request]:animate-pulse"
                    href="/?movie_id=<?= $movie->id ?>">
                    <img
                        style="<?= ($movie->id !== $single_movie->id) ? 'view-transition-name: image-'.$movie->id : '' ?>"
                        class="rounded"
                        src="<?= $movie->computed->poster_paths['w500'] ?>"
                        alt="<?= $movie->title ?> poster"
                    >
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <div>
        <div class="grid place-items-center sticky top-0 lg:h-dvh lg:pr-12">
            <article class="gap-8 flex flex-col flex-col-reverse items-center max-w-lg mx-auto lg:gap-10 lg:flex-row lg:max-w-4xl xl:max-w-5xl">
                <img
                    style="view-transition-name: image-<?= $has_member_id ? $member->id : $single_movie->id ?>"
                    class="h-full rounded-md shrink-0 lg:w-2/5"
                    src="<?= $has_member_id ? $member->computed->profile_paths['w500'] : $single_movie->computed->poster_paths['w500'] ?>"
                    alt="<?= $single_movie->title ?> poster"
                >
                <div
                    style="view-transition-name: title-<?= $single_movie->id ?>"
                    class="_lg:pb-10">
                    <h2 class="max-w-sm text-4xl">
                        <?= $single_movie->title ?>
                    </h2>
                    <div class="bg-slate-900/50 mt-8 p-4 rounded-md">
                        <p class="line-clamp-3 xl:line-clamp-5">
                            <?= $single_movie->overview ?>
                        </p>
                    </div>
                    <div class="gap-2 flex flex-wrap mt-4">
                        <?php foreach ($single_movie->genres as $genre): ?>
                            <span class="bg-slate-700 px-2 py-0.5 rounded-md text-sm">
                                <?= $genre->name ?>
                            </span>
                        <?php endforeach ?>
                    </div>
                    <hr class="border-slate-900 mt-8">
                    <div class="flex flex-col flex-col-reverse lg:flex-col">
                        <?php if ($has_member_id): ?>
                            <div class="gap-2 inline-flex mt-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-[3px] -rotate-90 shrink-0 size-6 lg:rotate-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="text-xl">
                                    <span><?= $member->name ?></span>
                                    <?php if ($member->character): ?>
                                        <span class="text-slate-400">(<?= $member->character ?>)</span>
                                    <?php endif ?>
                                </h3>
                            </div>
                        <?php endif ?>
                        <?php if ($members): ?>
                            <ul class="gap-4 grid grid-cols-4 max-w-sm mt-8">
                                <?php foreach ($members as $index => $member): ?>
                                    <li>
                                        <a
                                            class="[&.htmx-request]:animate-pulse"
                                            href="/?movie_id=<?= $single_movie->id ?>&member_id=<?= $member->id ?>">
                                            <img
                                                style="view-transition-name: image-<?= $member->id ?>"
                                                class="rounded"
                                                src="<?= $member->computed->profile_paths['w500'] ?>" />
                                        </a>
                                    </li>
                                <?php endforeach ?>
                                <?php if ($has_member_id): ?>
                                    <li>
                                        <a href="/?movie_id=<?= $single_movie->id ?>">
                                            <img
                                                style="<?= $movie->id !== $single_movie->id ? 'view-transition-name: image-'.$single_movie->id : '' ?>"
                                                class="rounded"
                                                src="<?= $single_movie->computed->poster_paths['w500'] ?>"
                                                alt="<?= $single_movie->title ?> poster"
                                            >
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>