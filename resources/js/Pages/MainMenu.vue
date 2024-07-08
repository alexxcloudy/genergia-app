<template>
    <div class="menu">
        <div class="mb-4">
            <Logo></Logo>
        </div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/dashboard">
            <icon name="dashboard" class="mr-2 w-4 h-4"
                :class="isUrl('dashboard') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
            <div :class="isUrl('dashboard') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
            </Link>
        </div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/organizations">
            <icon name="office" class="mr-2 w-4 h-4"
                :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
            <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Organizations
            </div>
            </Link>
        </div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/uploadcsv">
            <icon name="office" class="mr-2 w-4 h-4"
                :class="isUrl('uploadcsv') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
            <div :class="isUrl('uploadcsv') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">uploadcsv
            </div>
            </Link>
        </div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/contacts">
            <icon name="users" class="mr-2 w-4 h-4"
                :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
            <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
            </Link>
        </div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/reports">
            <icon name="printer" class="mr-2 w-4 h-4"
                :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
            <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';
import Logo from '@/Components/Logo.vue';

export default {
    components: {
        Icon,
        Link, Logo
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1);
            if (urls[0] === '') {
                return currentUrl === '';
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },
    },
};
</script>

<style>
.menu {
    width: 250px;
    background-color: #2d3748;
    /* You can adjust the color as needed */
    color: #cbd5e0;
    /* Text color */
    padding: 1rem;
    height: 100vh;
    /* Full height */
    position: fixed;
}
</style>
