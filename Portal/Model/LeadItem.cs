namespace Portal.Model
{
    public class LeadItem
    {
        public string CustomerName;
        public string ContactPerson;
        public string Email;
        public string Phone;
        public string LeadStatus;
        public string LeadSource;
        public string IndustrySegment;
        public string CustomerCategory;
        public List<ProductItem> ProductNeeds = new();
        public string AdditionalNotes;
        public string Name { get; set; }
        public string Company { get; set; }
        public string Stage { get; set; }
        public string Status { get; set; }
        public LeadItem()
        {
        }
        public LeadItem(string name, string company, string stage, string status = "")
        {
            Name = name;
            Company = company;
            Stage = stage;
            Status = status;
        }
    }
}
