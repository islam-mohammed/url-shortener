import NavLink from "@/Components/NavLink";
import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";

export default function ShortLinks({ auth, errors, shortLinks }) {
    const {
        data,
        meta: { links },
    } = shortLinks;

    const copyToClipboard = async (text) => {
        if ("clipboard" in navigator) {
            return await navigator.clipboard.writeText(text);
        } else {
            console.log("second");
            return document.execCommand("copy", true, text);
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
                        <div className="flex items-center ml-2 mb-6">
                            <TextInput className="w-64 md:w-96 whitespace-nowrap " />
                            <button
                                type="button"
                                className="bg-black text-white ml-1 py-2 px-6 rounded-md"
                            >
                                Create
                            </button>
                        </div>
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
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        {id}
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        {destination}
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
                                                        <NavLink
                                                            href={route(
                                                                "shortlink.view",
                                                                slug
                                                            )}
                                                            className="flex items-center px-6 py-4 focus:text-indigo-500"
                                                        >
                                                            {shortLink}
                                                        </NavLink>
                                                    </td>
                                                    <td className="border-t px-3 pt-2 pb-2">
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
