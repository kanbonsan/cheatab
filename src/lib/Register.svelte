<script lang="ts">
    import { Dialog } from "bits-ui";
    import XCircle from "phosphor-svelte/lib/XCircle";
    import {fade} from "svelte/transition"

    import axios from "axios";

    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    let dialogIsOpen = $state(false);
    let name = $state("");
    let loginEmail = $state("");
    let previousEmail = $state("")  // エラー前のメアド
    let loginPassword = $state("");
    let passwordConfirm = $state("")
    let uniqueEmailError = $state(false)

    let validPassword = $derived.by( ()=>{
        if( loginPassword === "" || passwordConfirm === "") return true
        return loginPassword === passwordConfirm
    })

    let isError = $state(false);
    let message = $state("ユーザー登録します. 本登録にはメールアドレスの確認が必要です.");
    let uniqueEmailMessage = $derived.by(()=>{
        if( uniqueEmailError && (loginEmail === previousEmail)){    // 書き換えが始まればメッセージを消す
            return "このメールアドレスはすでに使われています."
        }
        else {
            return ""
        }
    })

    const handleRegister = async function () {
        try {
            await axios.get("/sanctum/csrf-cookie");
            console.log('got csrf-cookie')
            const response = await axios.post("/api/register", {
                name: name,
                email: loginEmail,
                password: loginPassword,
                "password-confirmation": passwordConfirm,
            });

            console.log("registered",response)

        } catch (error: any) {
            
            console.log(error)

            message = "ユーザー登録に失敗しました. 入力内容をご確認ください.";

            const err: any = error.response.data.errors
            
            if((err.email)[0]==="email notunique"){
                uniqueEmailError = true
                previousEmail = loginEmail
            } else {
                uniqueEmailError = false
            }
            isError = true;
        } finally {
            console.log('register end')
        }
    };

</script>

    <button
        class="inline-flex h-12 items-center justify-center rounded-input bg-dark
	px-[21px] text-[15px] font-semibold  shadow-mini text-black
	hover:bg-dark/95 active:scale-98 active:transition-all"
        onclick={() => {
            dialogIsOpen = true;
        }}>ユーザー登録</button
    >

<Dialog.Root bind:open={dialogIsOpen} closeOnOutsideClick={false}>
    <Dialog.Portal>
        <Dialog.Overlay class="fixed inset-0 z-50 bg-black/40" 
        transition={fade}
        transitionConfig={{duration:150}}/>

        <Dialog.Content
            class="fixed left-[50%] top-[50%] z-50 w-full max-w-[94%]
                translate-x-[-50%] translate-y-[-50%] rounded-card-lg
                border-slate-600 rounded-lg bg-white p-5 sm:max-w-[490px] md:w-full"
        >
            <Dialog.Title
                class="flex w-full items-center justify-center text-lg text-slate-900 font-semibold tracking-tight"
                >CHEATAユーザー登録
            </Dialog.Title>

            <Dialog.Description class="text-sm text-foreground-alt my-5">
                <span class={isError ? "text-red-500" : "text-gray-500"}
                    >{message}</span
                >
            </Dialog.Description>
            <form onsubmit={() => handleRegister()}>
                <div class="mb-6">
                    <div class="mb-3">
                        <label
                            for="name"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >お名前</label
                        >
                        <input
                            type="text"
                            id="name"
                            bind:value={name}
                            class=" bg-gray-50 border border-gray-300 text-gray-900 focus:border-red-400 text-sm rounded-l block w-full p-2.5"
                            placeholder="あなたのお名前"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >Eメールアドレス <span class="text-red-500 font-normal">{uniqueEmailMessage}</span></label
                        >
                        <input
                            type="email"
                            id="email"
                            bind:value={loginEmail}
                            class=" bg-gray-50 border border-gray-300 text-gray-900 focus:border-red-400 text-sm rounded-l block w-full p-2.5"
                            placeholder="cheata@example.com"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label
                            for="password"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >パスワード</label
                        >
                        <input
                            type="password"
                            id="password"
                            bind:value={loginPassword}
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l focus:border-gray-500 block w-full p-2.5 focus:ring-4"
                            placeholder="•••••••••"
                            required
                        />
                    </div>
                    <div>
                        <label
                            for="password-confirm"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >パスワード確認 {#if !validPassword}<span class="text-red-500">パスワードが一致しません</span>{/if}</label
                        >
                        <input
                            type="password"
                            id="password-confirm"
                            bind:value={passwordConfirm}
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l focus:border-gray-500 block w-full p-2.5 focus:ring-4"
                            placeholder="•••••••••"
                            required
                        />
                    </div>
                </div>

                <button
                    type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >送信</button
                >
            </form>

            <Dialog.Close class="absolute right-5 top-5 active:scale-98">
                <XCircle size={30} />
            </Dialog.Close>
        </Dialog.Content>
    </Dialog.Portal>
</Dialog.Root>
