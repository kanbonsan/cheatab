<script lang="ts">
    import "../app.css";
    import type { Snippet } from "svelte";
    import Header from "$lib/Header.svelte";

    let { children }: { children: Snippet } = $props();
</script>

<div class="header"><Header/></div>
<div class="content">
    {@render children()}
</div>

<div class="footer bg-pink-400">
    footer
</div>

<style global lang="scss">
    :root {
        --header-height: 36px;
        --footer-height: 24px;
    }
    :global(body) {
        height: 100vh;
        width: 100vw;
    }
    .header {
        height: var(--header-height);
    }
    .content {
        height: calc(100vh - var(--header-height) - var(--footer-height));
    }
    .footer {
        height: var(--footer-height);
    }
</style>
