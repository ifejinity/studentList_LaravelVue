<template>
    <div class="join flex md:flex-row flex-col justify-center w-full my-5">
        <Link 
            v-for="page in data.links" 
            :href="`${page.url}`" 
            v-html="page.label" 
            :class="`join-item btn ${page.active == true ? 'btn-blue' : ''} ${page.url ?? 'btn-disabled'}`"
            :preserveScroll="true"
            :preserveState="true">
        </Link>
    </div>
</template>

<script setup>
    import { Link } from "@inertiajs/vue3";
    defineProps([
        'data'
    ])
</script>

<style lang="scss" scoped>

</style>