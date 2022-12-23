#include "pch.h"
#include <Windows.h>
#include <iostream>

int main()
{
    setlocale(LC_ALL, "Russian");
    DWORD pid_id = GetCurrentProcessId();
    HANDLE pse_handle = GetCurrentProcess();
    HANDLE dup_handle;
    DuplicateHandle(pse_handle, pse_handle, pse_handle, &dup_handle, 0, FALSE, DUPLICATE_SAME_ACCESS);
    HANDLE open_proc=OpenProcess(PROCESS_ALL_ACCESS,FALSE,pid_id);
    PROCESS_INFORMATION info;
    PROCESS_INFORMATION_CLASS info_class{};
    GetProcessInformation(pse_handle, info_class, &info, 256);

    std::cout << "Информация о текущем процессе:\n-----------------------------\n";
    std::cout << "Идентификатор: " << pid_id << "\n";
    std::cout << "Псевдодескриптор: " << info.dwProcessId << "\n";
    std::cout << "Дескриптор(DuplicateHandle): " << dup_handle << "\n";
    std::cout << "Дескриптор(OpenProcess): " << open_proc << "\n";

    CloseHandle(dup_handle);
    CloseHandle(open_proc);

    std::cout << "Закрываем дескриптор(OpenProcess): " << open_proc << "\n";
    std::cout << "Закрываем дескриптор(DuplicateHandle): " << dup_handle << "\n";

}
