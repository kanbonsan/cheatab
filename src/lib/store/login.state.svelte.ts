/**
 * Login情報
 */
type LoginState = {
    isLogin: boolean,
    name? : string,
    email? : string,
    username? : string,
}

export const loginState = $state<LoginState>({
    isLogin: false,
    name: undefined,
    email: undefined,
    username: undefined
})

export const resetState= ()=>{
    loginState.isLogin = false
    loginState.name = undefined
    loginState.email = undefined
    loginState.username = undefined
}