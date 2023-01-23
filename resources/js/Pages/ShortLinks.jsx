import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import LoadingButton from "@/Components/LoadingButton";
import NavLink from "@/Components/NavLink";
import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";

export default function ShortLinks({ shortLinks, auth, destination }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        destination: "",
        user_id: auth.user.id,
    });

    const {
        data: linksData,
        meta: { links },
    } = shortLinks;

    const copyToClipboard = async (text) => {
        if ("clipboard" in navigator) {
            return await navigator.clipboard.writeText(text);
        } else {
            return document.execCommand("copy", true, text);
        }
    };

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };
    const submit = async (e) => {
        e.preventDefault();
        await post(route("shortlink.store"));
        if (!errors?.destination) {
            reset("destination");
        }
    };
    return (
        <AuthenticatedLayout
            auth={auth}
            errors={errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Short Links
                </h2>
            }
        >
            <Head title="Short Links" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-1 md:p-4">
                        <form
                            className="flex items-top ml-2 mb-6"
                            onSubmit={submit}
                        >
                            <div>
                                <TextInput
                                    id="destination"
                                    placeholder="Add your link: http://example.com"
                                    className="w-64 md:w-96 whitespace-nowrap"
                                    name="destination"
                                    value={data.destination}
                                    handleChange={onHandleChange}
                                    required
                                />
                                <InputError
                                    message={
                                        errors.destination || errors.user_id
                                    }
                                    className="mt-2"
                                />
                            </div>
                            <LoadingButton
                                loading={processing}
                                type="submit"
                                className="bg-black text-white ml-1 py-2 px-6 rounded-md max-h-10"
                            >
                                Create
                            </LoadingButton>
                        </form>

                        <div className="overflow-x-auto bg-white rounded shadow">
                            <table className="w-full whitespace-nowrap">
                                <thead>
                                    <tr className="font-bold text-left">
                                        <th className="px-6 pt-5 pb-4">Link</th>
                                        <th className="px-6 pt-5 pb-4">
                                            Short Link
                                        </th>
                                        <th className="px-6 pt-5 pb-4">
                                            Visits
                                        </th>
                                        <th className="px-6 pt-5 pb-4">
                                            Last Visit
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {linksData.map(
                                        ({
                                            id,
                                            destination,
                                            shortLink,
                                            slug,
                                            views,
                                            lastUpdate,
                                        }) => {
                                            return (
                                                <tr
                                                    key={id}
                                                    className="hover:bg-gray-100 focus-within:bg-gray-100"
                                                >
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        {destination}
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        <div className="flex justify-between">
                                                            <NavLink
                                                                href={route(
                                                                    "shortlink.view",
                                                                    slug
                                                                )}
                                                                className="flex items-center px-6 py-4 focus:text-indigo-500"
                                                            >
                                                                {shortLink}
                                                            </NavLink>
                                                            <span>|</span>
                                                            <button
                                                                type="button"
                                                                className="text-sm"
                                                                onClick={async () => {
                                                                    await copyToClipboard(
                                                                        shortLink
                                                                    );
                                                                }}
                                                            >
                                                                Copy
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        {views}
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        {views
                                                            ? lastUpdate
                                                            : ""}
                                                    </td>
                                                </tr>
                                            );
                                        }
                                    )}
                                    {data.length === 0 && (
                                        <tr>
                                            <td
                                                className="px-6 py-4 border-t"
                                                colSpan="4"
                                            >
                                                No liks found.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                        <Pagination links={links} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
