<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('register'))
}
</script>

<template>
    <main class="flex max-h-svh min-h-svh w-full items-center justify-center">
        <Card class="mx-auto min-w-sm">
            <CardHeader>
                <CardTitle class="text-xl"> Sign Up </CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" type="text" required  v-model="form.name" />
                        <small class="text-red-500" v-if="form.errors.name">
                            {{ form.errors.name }}
                        </small>
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" required v-model="form.email" />
                        <small class="text-red-500" v-if="form.errors.email">
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
                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirm Password</Label>
                        <Input id="password_confirmation" type="password" required v-model="form.password_confirmation" />
                    </div>
                    <small class="text-red-500" v-if="form.errors.password_confirmation">
                        {{ form.errors.password_confirmation }}
                    </small>
                    <Button type="submit" class="w-full"> Create an account </Button>
                </form>
                <div class="mt-4 text-center text-sm">
                    Already have an account?
                    <Link :href="route('login')" class="text-rose-500 hover:underline">Sign in</Link>
                </div>
            </CardContent>
        </Card>
    </main>
</template>

<style scoped></style>
