using PracticWork9;

List<Phone> phones = new List<Phone>();


PersonCreate person = new PersonCreate();
phones.Add(person.GenerateNote("Илья Кузнецов", 89538318434));

IndividualCreate individual = new IndividualCreate();
phones.Add(individual.GenerateNote("ИП Кузнецов Илья Владиславович", 561023271508));

InstitutionCreate institution = new InstitutionCreate();
phones.Add(institution.GenerateNote("Оренбургский колледж Экономики и информатики", 5610046887));

foreach (var item in phones)
{
    Console.WriteLine(item.GetInfo());
}