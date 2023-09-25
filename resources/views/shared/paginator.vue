<template>
    <div class="join flex lg:flex-row flex-col justify-center w-full my-5 z-[0]">
        <Link 
            v-for="page in data.links" 
            :href="`${page.url}`" 
            v-html="page.label" 
            :class="`join-item btn ${page.active == true ? 'btn-blue' : ''} ${page.url ?? 'btn-disabled'}`"
            preserve-state
            preserve-scroll>

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