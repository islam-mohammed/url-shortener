import { Link, Head } from "@inertiajs/react";

export default function Welcome(props) {
    return (
        <>
            <Head title="Welcome" />
            <div className="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div className="fixed top-0 right-0 px-6 py-4 sm:block bg-white">
                    {props.auth.user ? (
                        <Link
                            href={route("dashboard")}
                            className="text-md text-gray-700 dark:text-gray-500"
                        >
                            Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link
                                href={route("login")}
                                className="text-md text-gray-700 dark:text-gray-500"
                            >
                                Log in
                            </Link>

                            <Link
                                href={route("register")}
                                className="ml-4 text-md text-gray-700 dark:text-gray-500"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </div>

                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <h2 className="text-3xl">Welcome Page Content</h2>
                </div>
            </div>
        </>
    );
}
