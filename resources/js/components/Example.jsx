import React from 'react';
import ReactDOM from 'react-dom/client';

function Example() {
    return (
        <div className="container mx-auto p-4">
            <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h1 className="text-xl font-bold mb-4">Contoh Komponen React</h1>
                <p className="text-gray-700 text-base">
                    Ini adalah contoh komponen React yang dirender di dalam aplikasi Laravel menggunakan Vite.
                </p>
                <button 
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4"
                    onClick={() => alert('Tombol React diklik!')}
                >
                    Klik Saya!
                </button>
            </div>
        </div>
    );
}

export default Example;

// Cari elemen dengan ID 'react-example-component' dan render komponen React di dalamnya
if (document.getElementById('react-example-component')) {
    const root = ReactDOM.createRoot(document.getElementById('react-example-component'));
    root.render(
        <React.StrictMode>
            <Example />
        </React.StrictMode>
    );
}