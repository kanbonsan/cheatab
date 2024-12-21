<script lang="ts">
    import { Dialog, PinInput } from "bits-ui";
    import XCircle from "phosphor-svelte/lib/XCircle";

    import { fade } from "svelte/transition";

    import axios from "axios";

    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    let dialogIsOpen = $state(false);
    let value: string[] | undefined = $state([]);
    const onValueChange = async function(){
        if( value?.includes("") ){  // 入力が終了していない
            return
        }

        const response = await axios.post("/api/confirm-email-verify",{
            key: value?.join(""),
        })
        console.log(response.data)
    }
</script>

<button
    class="inline-flex h-12 items-center justify-center rounded-input bg-dark
	px-[21px] text-[15px] font-semibold shadow-mini text-black
	hover:bg-dark/95 active:scale-98 active:transition-all"
    onclick={() => {
        dialogIsOpen = true;
    }}
    >メール確認
</button>
<p>{value}</p>
<Dialog.Root bind:open={dialogIsOpen} closeOnOutsideClick={false}>
    <Dialog.Portal>
        <Dialog.Overlay
            class="fixed inset-0 z-50 bg-black/40"
            transition={fade}
            transitionConfig={{ duration: 150 }}
        />

        <Dialog.Content
            class="fixed left-[50%] top-[50%] z-50 w-full max-w-[94%]
                translate-x-[-50%] translate-y-[-50%] rounded-card-lg
                border-slate-600 rounded-lg bg-white p-5 sm:max-w-[490px] md:w-full"
        >
            <Dialog.Title
                class="flex w-full items-center justify-center text-lg text-slate-900 font-semibold tracking-tight"
                >メールアドレス確認
            </Dialog.Title>

            <Dialog.Description class="text-sm text-foreground-alt my-5">
                メールでお送りした確認キーを入力してください
            </Dialog.Description>
            <form>
                <PinInput.Root
                    bind:value
                    class="flex items-center gap-2"
                    type={"text"}
                    placeholder="•"
                    onValueChange={onValueChange}
                >
                    <PinInput.Input
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.Input
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.Input
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.Input
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.Input
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.Input onkeyup={onValueChange}
                        class="flex h-input w-10 select-none rounded-input border border-foreground bg-background px-2 py-3 text-center font-alt text-[17px] tracking-[0.01em] text-foreground placeholder-shown:border-border-input focus-within:border-border-input-hover focus-within:shadow-date-field-focus hover:border-border-input-hover"
                    />
                    <PinInput.HiddenInput />
                </PinInput.Root>

                <button
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >メールをもう一度送る</button
                >
            </form>

            <Dialog.Close class="absolute right-5 top-5 active:scale-98">
                <XCircle size={30} />
            </Dialog.Close>
        </Dialog.Content>
    </Dialog.Portal>
</Dialog.Root>
