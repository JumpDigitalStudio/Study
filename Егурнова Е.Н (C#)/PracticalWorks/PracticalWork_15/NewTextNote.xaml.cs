using System;
using System.IO;
using System.Text;

using System.Windows;

namespace PracticalWork_15
{
    /// <summary>
    /// Логика взаимодействия для NewTextNote.xaml
    /// </summary>
    public partial class NewTextNote : Window
    {
        // Инициализация программы
        public NewTextNote()
        {
            InitializeComponent();
        }



        // Создание новой заметки
        public NewTextNote(Note note)
        {
            InitializeComponent();
            using (StreamReader reader = new StreamReader(note.Path))
            {
                string text = reader.ReadToEnd();
                NoteName.Text = note.Name;
                NoteContent.Text = text;
            }
        }



        // Сохранение заметки
        private void SaveButton_Click(object sender, RoutedEventArgs e)
        {
            string title = NoteName.Text;
            if (title == "" || title == " ")
            {
                MessageBox.Show("Придумайте название заметки", "Внимание");
                return;
            }
            string text = NoteContent.Text;
            if (text == "" || text == " ")
            {
                MessageBox.Show("Нельзя сохранить пустую заметку :(", "Внимание");
                return;
            }

            string exeDir = AppDomain.CurrentDomain.BaseDirectory;
            string relPath = @"..\data"; // Относительный путь к файлу
            string resPath = System.IO.Path.Combine(exeDir, relPath); // Объединяет две строки в путь.
            string currentDirectory = System.IO.Path.GetFullPath(resPath); // Возвращает для указанной строки пути абсолютный путь.

            string path = $"{currentDirectory}\\{title}.txt";
            if (!File.Exists(path))
            {
                using (FileStream fs = File.Create(path))
                {
                    byte[] info = new JsonSerializer.SerializeToUtf8Bytes(text);
                    fs.Write(info, 0, info.Length);
                }

                MainWindow PageAllNotes = new MainWindow();
                PageAllNotes.Show();
                this.Hide();
            }
            else
            {
                if (MessageBox.Show("Заметка с таким именем уже существует, перезпаписать?", "Внимание", MessageBoxButton.YesNo) == MessageBoxResult.Yes)
                {
                    using (FileStream fs = File.Create(path))
                    {
                        byte[] info = new JsonSerializer.SerializeToUtf8Bytes(text);
                        fs.Write(info, 0, info.Length);
                    }

                    MainWindow PageAllNotes = new MainWindow();
                    PageAllNotes.Show();
                    this.Hide();
                }
            }
        }
        // Возврат к начальному окну
        private void BackButton_Click(object sender, RoutedEventArgs e)
        {
            MainWindow PageAllNotes = new MainWindow();
            PageAllNotes.Show();
            this.Hide();
        }
    }
}
