
<template>
  <div class="flex justify-center items-center h-screen bg-[#687c8d]">
    <div class="max-w-md w-full p-6 bg-[#e8edf2] rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold">Register</h2>
      <hr class="w-full border-[#687c8d] mb-4 mt-4">
      <form @submit.prevent="handleRegister" class="space-y-4">
        <div>
          <label for="name" class="block mb-1">Name</label>
          <input type="name" id="name" v-model="state.user.name" placeholder="Enter your name"
            :class="{ 'border-red-500': state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.name }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.name"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.name[0] }}</p>
        </div>
        <div>
          <label for="email" class="block mb-1">Email</label>
          <input type="email" id="email" v-model="state.user.email" placeholder="Enter your email"
            :class="{ 'border-red-500': state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.email"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.email[0] }}</p>
        </div>
        <div>
          <label for="password" class="block mb-1">Password</label>
          <input type="password" id="password" v-model="state.user.password" placeholder="Enter your password"
            :class="{ 'border-red-500': state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password }"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#687c8d]">
          <p v-if="state.errors && state.errors._data && state.errors._data.errors && state.errors._data.errors.password"
            class="text-[#ff7765] text-sm tracking-wide font-medium">{{ state.errors._data.errors.password[0] }}</p>
        </div>
        <button type="submit" class="w-full px-4 py-2 text-white bg-[#687c8d] rounded">
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

const state = reactive({
  errors: null,
  user: {
    name: null,
    email: null,
    password: null,
  }
})

async function handleRegister() {
  const params = {
    name: state.user.name,
    email: state.user.email,
    password: state.user.password,
  }

  try {
    const response = await $fetch(`http://127.0.0.1:8000/api/auth/register`, {
      method: 'POST',
      body: params
    })

    if (response.data) {
      alert('Successfully registered!')
      navigateTo('/');
    }
  }
  catch (error) {
    state.errors = error.response;
    console.log('error', error);
  }
}
</script>

