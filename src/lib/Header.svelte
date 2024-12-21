<script lang="ts">
    import Login from "$lib/Login.svelte"
    import Register from "$lib/Register.svelte"
    import ConfirmEmail from "./ConfirmEmail.svelte";
    import { loginState } from "$lib/store/login.state.svelte";
</script>

<div class="container mx-auto bg-orange-100 flex justify-between">
    
    <p class="text-4xl text-orange-500 font-semibold">CHEATA (チータ)</p>
    <div class="inline-flex">
    <Login/>
    {#if !loginState.isLogin}
    <Register/>
    {/if}
    <ConfirmEmail/>
    </div>

    
</div>
