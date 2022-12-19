using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace zametki
{
    /// <summary>
    /// Логика взаимодействия для OpenTxtWindow.xaml
    /// </summary>
    public partial class OpenTxtWindow : Window
    {
        public OpenTxtWindow()
        {
            InitializeComponent();
        }
        public OpenTxtWindow(Note note)
        {
            InitializeComponent();
            using (StreamReader reader = new StreamReader(note.Path))
            {
                string text = reader.ReadToEnd();
                tb_text.Text = text;
                tb_title.Text = note.Name;
            }
        }

        private void btn_save_Click(object sender, RoutedEventArgs e)
        {
            string title = tb_title.Text;
            if(title == "" || title == " ")
            {
                MessageBox.Show("error", "заголовок не должен быть пустым");
                return;
            }
            string text = tb_text.Text;
            if(text == "" || text == " ")
            {
                MessageBox.Show("error", "содержимое заметки не может быть пустым");
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
                    byte[] info = new UTF8Encoding(true).GetBytes(text);
                    fs.Write(info, 0, info.Length);
                }
                DialogResult = true;
                Close();
            }
            else
            {
                if (MessageBox.Show("предупреждение", "заметка уже существует, перезпаписать?", MessageBoxButton.YesNo) == MessageBoxResult.Yes)
                {
                    using (FileStream fs = File.Create(path))
                    {
                        byte[] info = new UTF8Encoding(true).GetBytes(text);
                        fs.Write(info, 0, info.Length);
                    }
                    DialogResult = true;
                    Close();
                }
            }
        }
    }
}
