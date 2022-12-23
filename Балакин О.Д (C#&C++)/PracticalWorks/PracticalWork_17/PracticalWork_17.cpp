#include <iostream>
#include <Windows.h>
#include <locale>
#include <string>
#include <codecvt>
#include "WinReg.h"

#pragma warning(disable:4996)
#define INFO_BUFFER_SIZE 32767
#define BUFFER 255

using namespace std;

std::wstring GetStringValueFromHKLM(const std::wstring& regSubKey, const std::wstring& regValue)
{
    size_t bufferSize = 0xFFF;
    std::wstring valueBuf;
    valueBuf.resize(bufferSize);
    auto cbData = static_cast<DWORD>(bufferSize * sizeof(wchar_t));
    auto rc = RegGetValueW(
        HKEY_LOCAL_MACHINE,
        regSubKey.c_str(),
        regValue.c_str(),
        RRF_RT_REG_SZ,
        nullptr,
        static_cast<void*>(valueBuf.data()),
        &cbData
    );
    while (rc == ERROR_MORE_DATA)
    {
        // Get a buffer that is big enough.
        cbData /= sizeof(wchar_t);
        if (cbData > static_cast<DWORD>(bufferSize))
        {
            bufferSize = static_cast<size_t>(cbData);
        }
        else
        {
            bufferSize *= 2;
            cbData = static_cast<DWORD>(bufferSize * sizeof(wchar_t));
        }
        valueBuf.resize(bufferSize);
        rc = RegGetValueW(
            HKEY_LOCAL_MACHINE,
            regSubKey.c_str(),
            regValue.c_str(),
            RRF_RT_REG_SZ,
            nullptr,
            static_cast<void*>(valueBuf.data()),
            &cbData
        );
    }
    if (rc == ERROR_SUCCESS)
    {
        cbData /= sizeof(wchar_t);
        valueBuf.resize(static_cast<size_t>(cbData - 1)); // remove end null character
        return valueBuf;
    }
    else
    {
        throw std::runtime_error("Windows system error code: " + std::to_string(rc));
    }
}

int main(void) {
    TCHAR  infoBuf[INFO_BUFFER_SIZE];
    DWORD  bufCharCount = INFO_BUFFER_SIZE;
    // Get and display the name of the computer.
    if (GetComputerName(infoBuf, &bufCharCount))
        wcout << "PcName: " << infoBuf << endl;

    TCHAR sysDir[MAX_PATH];
    GetSystemDirectory(sysDir, MAX_PATH);
    wcout << "SysDir: " << sysDir << endl;

    const DWORD encodedVersion = ::GetVersion();
    const unsigned majorVersion = unsigned(LOBYTE(LOWORD(encodedVersion)));
    const unsigned minorVersion = unsigned(HIBYTE(LOWORD(encodedVersion)));

    std::printf("Windows ver: %u.%u\n", majorVersion, minorVersion);

    std::ios_base::sync_with_stdio(false);
    std::locale utf8(std::locale(), new std::codecvt_utf8_utf16<wchar_t>);
    std::wcout.imbue(utf8);

    try
    {
        wcout << "BIOS Vendor: " << GetStringValueFromHKLM(L"HARDWARE\\DESCRIPTION\\System\\BIOS", L"BIOSVendor") << endl;
        wcout << "BIOS Version: " << GetStringValueFromHKLM(L"HARDWARE\\DESCRIPTION\\System\\BIOS", L"BIOSVersion") << endl;
        wcout << "SystemManufacturer: " << GetStringValueFromHKLM(L"HARDWARE\\DESCRIPTION\\System\\BIOS", L"SystemManufacturer") << endl;
        winreg::RegKey key;
        winreg::RegResult result = key.TryOpen(HKEY_LOCAL_MACHINE, L"Software\\7-Zip");
        cout << "Autoload keys:" << endl;
        if (result)
        {
            auto values = key.EnumValues();
            for (auto v : values)
            {
                wcout << v.first << endl;
            }
        }
    }
    catch (std::exception& e)
    {
        std::cerr << e.what();
    }
}
