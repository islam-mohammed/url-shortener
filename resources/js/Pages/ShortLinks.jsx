import NavLink from "@/Components/NavLink";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function ShortLinks({ auth, errors, shortLinks }) {
    const {
        data,
        meta: { links },
    } = shortLinks;
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
                        <div className="overflow-x-auto bg-white rounded shadow">
                            <table className="w-full whitespace-nowrap">
                                <thead>
                                    <tr className="font-bold text-left">
                                        <th className="px-6 pt-5 pb-4">Id</th>
                                        <th className="px-6 pt-5 pb-4">Link</th>
                                        <th className="px-6 pt-5 pb-4">
                                            Short Link
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.map(
                                        ({
                                            id,
                                            destination,
                                            shortLink,
                                            slug,
                                        }) => {
                                            return (
                                                <tr
                                                    key={id}
                                                    className="hover:bg-gray-100 focus-within:bg-gray-100"
                                                >
                                                    <td className="border-t">
                                                        {id}
                                                    </td>
                                                    <td className="border-t">
                                                        {destination}
                                                    </td>
                                                    <td className="border-t">
                                                        <NavLink
                                                            href={route(
                                                                "shortlink.view",
                                                                slug
                                                            )}
                                                            className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                                        >
                                                            {shortLink}
                                                        </NavLink>
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
