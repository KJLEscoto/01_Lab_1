<template>
  <div class="flex justify-center items-center h-screen bg-[#687c8d]">
    <div class="max-w-md w-full p-6 bg-[#e8edf2] rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold">Sign Up</h2>
      <hr class="w-full border-[#687c8d] mb-4 mt-4">
      <form @submit.prevent="handleRegister" class="space-y-4">
        <div>
          <label for="name" class="block mb-1">Name</label>
          <input type="name" id="name" v-model="state.user.name" placeholder="Enter your name"
            :class="{ 'border-red-500': (state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.name) || (v$.user.name.$errors && v$.user.name.$errors.length > 0) }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="v$.user.name.$errors && v$.user.name.$errors.length > 0"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{
        v$.user.name.$errors[0].$message }}</p>
          <p v-else-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.name"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.name[0] }}</p>
        </div>

        <div>
          <label for="email" class="block mb-1">Email</label>
          <input id="email" v-model="state.user.email" placeholder="Enter your email"
            :class="{ 'border-red-500': (state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email) || (v$.user.email.$errors && v$.user.email.$errors.length > 0) }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="v$.user.email.$errors && v$.user.email.$errors.length > 0"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{
        v$.user.email.$errors[0].$message }}</p>
          <p v-else-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.email[0] }}</p>
        </div>

        <div>
          <label for="password" class="block mb-1">Password</label>
          <input type="password" id="password" v-model="state.user.password" placeholder="Enter your password"
            :class="{ 'border-red-500': (state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password) || (v$.user.password.$errors && v$.user.password.$errors.length > 0) }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="v$.user.password.$errors && v$.user.password.$errors.length > 0"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{
        v$.user.password.$errors[0].$message }}</p>
          <p v-else-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.password[0] }}</p>
        </div>
        <button type="submit" class="w-full px-4 py-2 text-white bg-[#687c8d] rounded hover:bg-[#8495a3] duration-200">
          Register
        </button>

        <div class="flex text-center">
          <nuxt-link to="/" class="m-auto text-[#99b1c5] text-sm hover:underline">Already registered? Login
            here.</nuxt-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';

const state = reactive({
  errors: null,
  user: {
    name: null,
    email: null,
    password: null,
  }
})

const rules = computed(() => {
  return {
    user: {
      name: {
        required: helpers.withMessage('Please enter your name.', required)
      },
      email: {
        required: helpers.withMessage('Please enter your email.', required),
        email: helpers.withMessage('Please enter a valid email address.', email)
      },
      password: {
        required: helpers.withMessage('Please enter your password.', required)
      }
    }
  }
})

const v$ = useVuelidate(rules, state);

async function handleRegister() {
  const params = {
    name: state.user.name,
    email: state.user.email,
    password: state.user.password,
  }

  const result = await v$.value.$validate();

  try {
    if (result) {
      const response = await $fetch(`http://127.0.0.1:8000/api/auth/register`, {
        method: 'POST',
        body: params
      })

      if (response.data) {
        alert('Successfully registered!')
        navigateTo('/');
      }
    }
  }
  catch (error) {
    state.errors = error.response;
    console.log('error', error);
  }
}
</script>
