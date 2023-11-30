import { useSignIn, useSignOut, useAuthUser, useAuthHeader, useIsAuthenticated, RequireAuth, } from "react-auth-kit";
import { Navigate, Outlet, useNavigate } from "react-router-dom";

export const Authenticate = ({acceptRoles}) => {
  const authUser = useAuthUser();

  const auth = <RequireAuth loginPath={"/signin"}><Outlet /></RequireAuth>

  if(acceptRoles === undefined) return auth
  if(acceptRoles !== undefined && acceptRoles.includes(authUser()?.role)) {
    return auth
  }
  else {
    return <Navigate to={'/signin'}/>  
  }
}
{/* <Authenticate acceptRoles={['admin','user']} /> */}


export const AllowRoles = ({acceptRoles, children}) => {
  const authUser = useAuthUser();

  const component = <>{children}</>

  if(acceptRoles === undefined) return component
  if(acceptRoles !== undefined && acceptRoles.includes(authUser()?.role)) return component

  return <></>

}

export const Signin = () => {
  const signIn = useSignIn();
  const nav = useNavigate()
  
  function sign(){
    signIn({
      token: '1234567890', //string	The Authentication token (JWT) to be stored from server
      expiresIn: '10', //number	The time for which the auth token will last, in minutes
      tokenType: "Bearer", //string | 'Bearer'	The type of authentication token.
      authState: {name:'mike', role:'admin'}, //object (optional)	State of the authorized user. Eg: {name: Jhon, email: jhon@auth.com}
    }) && nav('/secure')  
  }
  
  return (
    <button onClick={sign}>
      Login
    </button>
  )
}

export const Signout = () => {
  const signOut = useSignOut();

  return <button onClick={() => signOut()}>Sign Out</button>;
};

export const AuthData = () => {
  const auth = useAuthUser();
  const authHeader = useAuthHeader();
  const isAuthenticated = useIsAuthenticated();

  if (isAuthenticated()) {
    // Redirect to Dashboard
  } else {
    // Redirect to Login
  }

  return (
    <div>
      Hello {auth().user}
      {authHeader()}
    </div>
  );
};
