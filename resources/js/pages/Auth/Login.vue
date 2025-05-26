<script setup lang="ts">

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
})

function submit() {
    form.post(route('login'))
}
</script>

<template>
    <main class="w-full min-h-svh max-h-svh flex items-center justify-center">
        <Card class="w-full max-w-sm ">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Login
                </CardTitle>
            </CardHeader>
            <CardContent class="">
                <form class="grid gap-4" @submit.prevent="submit">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" v-model="form.email" required />
                        <small class="text-red-500" v-if="form.errors.email" >
                            {{ form.errors.email }}
                        </small>
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input id="password" type="password" required v-model="form.password" />
                        <small class="text-red-500" v-if="form.errors.password">
                            {{ form.errors.password }}
                        </small>
                    </div>
                    <Button class="w-full cursor-pointer">
                        Sign in
                    </Button>
                </form>
            </CardContent>
            <CardFooter>
                <p class="text-sm">
                    Don't have an account? <Link :href="route('register')" class="text-rose-500 hover:underline">Register</Link>
                </p>
            </CardFooter>
        </Card>
    </main>
</template>

<style scoped>

</style>
